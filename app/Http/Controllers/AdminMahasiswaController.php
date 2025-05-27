<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\FinancialRecord;

class AdminMahasiswaController extends Controller
{
    public function index(Request $request, $angkatan = null)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $mahasiswa = [];
        $angkatanList = [];
        $payments = [];
        $angkatanSelected = $angkatan;
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        $namaBulan = '';

        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if ($bulan && isset($bulanList[(int)$bulan])) {
            $namaBulan = $bulanList[(int)$bulan];
        }

        try {
            $startTime = microtime(true);

            // Gunakan caching untuk data API
            $mahasiswaList = Cache::remember('mahasiswa_aktif', 3600, function () use ($token) {
                $response = Http::withToken($token)
                    ->timeout(60)
                    ->retry(3, 1000)
                    ->get('https://cis.del.ac.id/api/library-api/mahasiswa?status=Aktif');

                if (!$response->successful()) {
                    throw new \Exception('Gagal mengambil data mahasiswa: ' . $response->status());
                }

                return $response->json();
            });

            $mahasiswa = $mahasiswaList['data']['mahasiswa'] ?? [];

            // Filter hanya mahasiswa dengan prodi DIII Teknologi Informasi
            $mahasiswa = array_filter($mahasiswa, function ($mhs) {
                return $mhs['prodi_name'] == 'DIII Teknologi Informasi';
            });

            // Ambil semua angkatan yang tersedia untuk tab
            $angkatanList = array_unique(array_column($mahasiswa, 'angkatan'));
            sort($angkatanList);

            // Jika angkatan tidak ditentukan, redirect ke angkatan pertama
            if (!$angkatan && !empty($angkatanList)) {
                return redirect()->route('admin.kas.index', [
                    'angkatan' => $angkatanList[0],
                    'bulan' => $bulan,
                    'tahun' => $tahun
                ]);
            }

            // Filter berdasarkan angkatan yang dipilih
            if ($angkatan) {
                $mahasiswa = array_filter($mahasiswa, function ($mhs) use ($angkatan) {
                    return $mhs['angkatan'] == $angkatan;
                });
            } else {
                $mahasiswa = [];
            }

            // Ambil data pembayaran berdasarkan bulan dan tahun
            if ($bulan && $tahun && !empty($mahasiswa)) {
                $payments = Payment::whereIn('nim', array_column($mahasiswa, 'nim'))
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->pluck('nim')
                    ->toArray();
            }

            $executionTime = microtime(true) - $startTime;
            Log::info('Data mahasiswa berhasil diambil untuk angkatan ' . ($angkatan ?? 'tidak ada'), [
                'count' => count($mahasiswa),
                'bulan' => $bulan,
                'tahun' => $tahun,
                'execution_time' => $executionTime,
                'cache_used' => Cache::has('mahasiswa_aktif') ? 'Ya' : 'Tidak'
            ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gagal terhubung ke API: ' . $e->getMessage());
            return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments', 'bulan', 'tahun', 'namaBulan'))
                ->withErrors(['error' => 'Tidak dapat terhubung ke server API. Silakan coba lagi nanti.']);
        } catch (\Exception $e) {
            Log::error('Error di AdminMahasiswaController: ' . $e->getMessage());
            return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments', 'bulan', 'tahun', 'namaBulan'))
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments', 'bulan', 'tahun', 'namaBulan'));
    }

    public function store(Request $request)
    {
        $mahasiswaBayar = $request->input('bayar', []);
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        if (!$bulan || !$tahun) {
            return back()->withErrors(['error' => 'Bulan dan tahun harus dipilih.']);
        }

        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $notifications = [];
        $totalMahasiswaBayar = 0; // Variabel untuk menghitung jumlah mahasiswa yang membayar

        foreach ($mahasiswaBayar as $nim => $data) {
            if (isset($data['bayar']) && $data['bayar'] == '1') {
                Payment::updateOrCreate(
                    [
                        'nim' => $nim,
                        'bulan' => $bulan,
                        'tahun' => $tahun
                    ],
                    [
                        'nama' => $data['nama'],
                        'angkatan' => $data['angkatan'],
                        'prodi' => $data['prodi'],
                        'tanggal_bayar' => now()->toDateString()
                    ]
                );

                $totalMahasiswaBayar++; // Tambah jumlah mahasiswa yang membayar

                $message = "Uang kas {$bulanList[$bulan]} sudah dibayar";

                // Simpan notifikasi ke database
                Notification::create([
                    'nim' => $nim,
                    'message' => $message,
                    'is_read' => false,
                ]);

                // Gunakan created_at untuk notifikasi admin
                $date = now()->format('d M Y');

                // Tambahkan notifikasi untuk admin (opsional)
                $notifications[] = [
                    'message' => $message,
                    'date' => $date,
                    'nim' => $nim
                ];
            } else {
                Payment::where('nim', $nim)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->delete();
            }
        }

        // Hitung total pemasukan (jumlah mahasiswa yang membayar × 5000)
        $totalPemasukan = $totalMahasiswaBayar * 5000;

        // Cek apakah sudah ada pemasukan untuk bulan dan tahun ini
        $tanggalPemasukan = "{$tahun}-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";

        $existingRecord = FinancialRecord::where('keterangan', "Pemasukan Kas Mahasiswa {$bulanList[$bulan]} {$tahun}")
            ->whereDate('tanggal', $tanggalPemasukan)
            ->first();

        if ($existingRecord) {
            $existingRecord->update([
                'jumlah' => $totalPemasukan,
                'tanggal' => $tanggalPemasukan,
            ]);
        } else {
            FinancialRecord::create([
                'tanggal' => $tanggalPemasukan,
                'keterangan' => "Pemasukan Kas Mahasiswa {$bulanList[$bulan]} {$tahun}",
                'jenis' => 'Pemasukan',
                'jumlah' => $totalPemasukan,
            ]);
        }


        if (!empty($notifications)) {
            session()->flash('notifications', $notifications);
        }

        Log::info('Pemasukan kas mahasiswa disimpan', [
            'bulan' => $bulanList[$bulan],
            'tahun' => $tahun,
            'total_mahasiswa' => $totalMahasiswaBayar,
            'total_pemasukan' => $totalPemasukan
        ]);

        return back()->with('success', 'Data pembayaran dan pemasukan keuangan berhasil disimpan.');
    }
    public function getPayments(Request $request)
{
    $bulan = $request->query('bulan');
    $tahun = $request->query('tahun');

    $query = \App\Models\Payment::query();

    if ($bulan) $query->where('bulan', $bulan);
    if ($tahun) $query->where('tahun', $tahun);

    $payments = $query->get();

    return response()->json([
        'status' => 'success',
        'data' => $payments
    ]);
}
}
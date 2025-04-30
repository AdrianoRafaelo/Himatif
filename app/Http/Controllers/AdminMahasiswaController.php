<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

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

        try {
            $response = Http::withToken($token)
                ->timeout(60)
                ->retry(3, 1000)
                ->get('https://cis.del.ac.id/api/library-api/mahasiswa?status=Aktif');

            if ($response->successful()) {
                $mahasiswaList = $response->json();
                $mahasiswa = $mahasiswaList['data']['mahasiswa'] ?? [];

                // Filter hanya mahasiswa dengan prodi DIII Teknologi Informasi
                $mahasiswa = array_filter($mahasiswa, function ($mhs) {
                    return $mhs['prodi_name'] == 'DIII Teknologi Informasi';
                });

                // Ambil semua angkatan yang tersedia untuk tab
                $angkatanList = array_unique(array_column($mahasiswa, 'angkatan'));
                sort($angkatanList); // Urutkan angkatan

                // Jika angkatan tidak ditentukan, redirect ke angkatan pertama
                if (!$angkatan && !empty($angkatanList)) {
                    return redirect()->route('admin.kas.index', ['angkatan' => $angkatanList[0]]);
                }

                // Filter berdasarkan angkatan yang dipilih
                if ($angkatan) {
                    $mahasiswa = array_filter($mahasiswa, function ($mhs) use ($angkatan) {
                        return $mhs['angkatan'] == $angkatan;
                    });
                } else {
                    $mahasiswa = []; // Jika tidak ada angkatan, kosongkan data
                }

                // Ambil data pembayaran untuk menentukan status checkbox
                $payments = Payment::whereIn('nim', array_column($mahasiswa, 'nim'))
                    ->where('tanggal_bayar', now()->toDateString())
                    ->pluck('nim')
                    ->toArray();

                Log::info('Data mahasiswa berhasil diambil untuk angkatan ' . ($angkatan ?? 'tidak ada'), ['count' => count($mahasiswa)]);
            } else {
                Log::warning('Gagal mengambil data mahasiswa dari API', ['status' => $response->status()]);
                return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments'))
                    ->withErrors(['error' => 'Gagal mengambil data mahasiswa: ' . $response->status()]);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gagal terhubung ke API: ' . $e->getMessage());
            return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments'))
                ->withErrors(['error' => 'Tidak dapat terhubung ke server API. Silakan coba lagi nanti.']);
        } catch (\Exception $e) {
            Log::error('Error di AdminMahasiswaController: ' . $e->getMessage());
            return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments'))
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        return view('admin.kas.index', compact('mahasiswa', 'angkatanList', 'angkatan', 'payments'));
    }

    public function store(Request $request)
    {
        $mahasiswaBayar = $request->input('bayar', []);

        foreach ($mahasiswaBayar as $nim => $data) {
            if (isset($data['bayar']) && $data['bayar'] == '1') { // Hanya simpan jika checkbox dicentang
                Payment::updateOrCreate(
                    ['nim' => $nim, 'tanggal_bayar' => now()->toDateString()],
                    [
                        'nama' => $data['nama'],
                        'angkatan' => $data['angkatan'],
                        'prodi' => $data['prodi'],
                    ]
                );
            } else {
                // Hapus pembayaran jika checkbox tidak dicentang
                Payment::where('nim', $nim)
                    ->where('tanggal_bayar', now()->toDateString())
                    ->delete();
            }
        }

        return back()->with('success', 'Data pembayaran berhasil disimpan.');
    }
}   
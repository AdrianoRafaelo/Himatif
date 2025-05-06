<?php

namespace App\Http\Controllers;

use App\Models\Bph;
use App\Models\LocalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AdminBphController extends Controller
{
    public function index(Request $request)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        // Definisikan hierarki jabatan
        $positionOrder = [
            'Ketua' => 1,
            'Wakil Ketua' => 2,
            'Sekretaris 1' => 3,
            'Sekretaris 2' => 4,
            'Bendahara 1' => 5,
            'Bendahara 2' => 6,
        ];

        // Ambil data BPH dan urutkan berdasarkan hierarki jabatan
        $bphs = Bph::with('user')
                   ->get()
                   ->sortBy(function ($bph) use ($positionOrder) {
                       return $positionOrder[$bph->position] ?? 999; // Jabatan yang tidak ada di hierarki akan diurutkan terakhir
                   });

        $mahasiswa = [];

        try {
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

            // Tangani struktur respons API
            $mahasiswa = $mahasiswaList['data']['mahasiswa'] ?? [];

            // Filter hanya mahasiswa dengan prodi DIII Teknologi Informasi
            $mahasiswa = array_filter($mahasiswa, function ($mhs) {
                return $mhs['prodi_name'] == 'DIII Teknologi Informasi';
            });

            Log::info('Data mahasiswa berhasil diambil untuk BPH', [
                'count' => count($mahasiswa),
                'cache_used' => Cache::has('mahasiswa_aktif') ? 'Ya' : 'Tidak'
            ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gagal terhubung ke API: ' . $e->getMessage());
            return view('admin.bph.index', compact('bphs', 'mahasiswa'))
                ->withErrors(['error' => 'Tidak dapat terhubung ke server API. Silakan coba lagi nanti.']);
        } catch (\Exception $e) {
            Log::error('Error di AdminBphController: ' . $e->getMessage());
            return view('admin.bph.index', compact('bphs', 'mahasiswa'))
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        return view('admin.bph.index', compact('bphs', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $request->validate([
            'nim' => 'required|string',
            'position' => 'required|string|in:Ketua,Wakil Ketua,Sekretaris 1,Sekretaris 2,Bendahara 1,Bendahara 2',
            'period' => 'required|string|regex:/^\d{4}-\d{4}$/', // Format: 2025-2026
        ]);

        // Validasi NIM melalui API
        try {
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

            $mahasiswa = collect($mahasiswaList['data']['mahasiswa'] ?? [])->firstWhere('nim', $request->nim);
            if (!$mahasiswa) {
                return redirect()->back()->with('error', 'NIM tidak ditemukan atau mahasiswa tidak aktif.');
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gagal terhubung ke API: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat terhubung ke server API. Silakan coba lagi nanti.');
        } catch (\Exception $e) {
            Log::error('Error di AdminBphController store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Cek apakah posisi sudah ada untuk periode ini
        $existingBph = Bph::where('position', $request->position)
                         ->where('period', $request->period)
                         ->first();
        if ($existingBph) {
            return redirect()->back()->with('error', 'Posisi ' . $request->position . ' untuk periode ' . $request->period . ' sudah diisi.');
        }

        // Pastikan atau buat LocalUser berdasarkan NIM
        $user = LocalUser::firstOrCreate(
            ['username' => $request->nim],
            ['nama' => $mahasiswa['nama'] ?? $request->nim]
        );

        // Simpan anggota BPH
        Bph::create([
            'user_id' => $user->id,
            'position' => $request->position,
            'period' => $request->period,
        ]);

        return redirect()->route('admin.bph.index')->with('success', 'Anggota BPH berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $bph = Bph::findOrFail($id);
        $bph->delete();

        return redirect()->route('admin.bph.index')->with('success', 'Anggota BPH berhasil dihapus.');
    }
}
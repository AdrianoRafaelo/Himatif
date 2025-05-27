<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\CampusStudent;

class CampusApiMahasiswaController extends Controller
{
    public function __construct()
    {
        try {
            if (!Schema::hasTable('campus_students')) {
                DB::statement('
                    CREATE TABLE IF NOT EXISTS campus_students (
                        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                        dim_id bigint(20) UNSIGNED NULL,
                        user_id bigint(20) UNSIGNED NULL,
                        user_name varchar(255) NULL,
                        nim varchar(255) NOT NULL,
                        nama varchar(255) NOT NULL,
                        email varchar(255) NULL,
                        prodi_id bigint(20) UNSIGNED NULL,
                        prodi_name varchar(255) NOT NULL,
                        fakultas varchar(255) NULL,
                        angkatan int(11) NOT NULL,
                        status varchar(255) NOT NULL DEFAULT "Aktif",
                        asrama varchar(255) NULL,
                        created_at timestamp NULL DEFAULT NULL,
                        updated_at timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (id),
                        UNIQUE KEY campus_students_nim_unique (nim)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ');
                
                Log::info('Tabel campus_students berhasil dibuat menggunakan raw SQL.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal membuat tabel campus_students: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan daftar mahasiswa dari database.
     *
     * @return \Illuminate\View\View
     */
    public function listStudents(Request $request)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $selectedBatch = $request->input('batch', 'all');
        
        try {
            $students = CampusStudent::getAllStudents($selectedBatch);
            $angkatanList = CampusStudent::getDistinctBatches();
        } catch (\Exception $e) {
            $students = collect([]);
            $angkatanList = [];
            Log::error('Gagal mengambil data mahasiswa: ' . $e->getMessage());
        }

        return view('admin.campus-students.index', [
            'students' => $students,
            'angkatanList' => $angkatanList,
            'selectedBatch' => $selectedBatch
        ]);
    }

    /**
     * Mengambil dan menyimpan data mahasiswa dari API untuk semua angkatan.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fetchAndSaveAllStudents(Request $request)
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $batches = ['2022', '2023', '2024'];
        $errors = [];
        $success = [];

        try {
            foreach ($batches as $batch) {
                $nimPrefix = ($batch == '2024') ? '42324' : '113' . substr($batch, -2);
                $url = "https://cis.del.ac.id/api/library-api/mahasiswa?nim={$nimPrefix}&status=Aktif";
                $response = $this->fetchFromApi($token, $url);

                if ($response['success']) {
                    $this->saveStudentsToDatabase($response['data']);
                    $success[] = "Berhasil menyinkronkan data mahasiswa angkatan {$batch}.";
                } else {
                    $errors[] = "Gagal mengambil data mahasiswa angkatan {$batch}: " . $response['message'];
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal saat mengambil dan menyimpan data mahasiswa: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat sinkronisasi: ' . $e->getMessage()]);
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        return back()->with('success', implode(' ', $success));
    }

    /**
     * Mengambil data dari API.
     *
     * @param string $token
     * @param string $url
     * @return array
     */
    private function fetchFromApi($token, $url)
    {
        try {
            $response = Http::withToken($token)
                ->timeout(60)
                ->retry(3, 1000)
                ->get($url);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['result']) && $data['result'] === 'Ok' && isset($data['data']['mahasiswa'])) {
                    return [
                        'success' => true,
                        'data' => $data['data']['mahasiswa']
                    ];
                }
                return [
                    'success' => false,
                    'message' => 'Format respons API tidak sesuai.'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'API mengembalikan status: ' . $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Permintaan API gagal: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Menyimpan data mahasiswa ke database.
     *
     * @param array $students
     */
    private function saveStudentsToDatabase($students)
    {
        try {
            foreach ($students as $studentData) {
                if ($studentData['prodi_name'] == 'DIII Teknologi Informasi') {
                    DB::table('campus_students')->updateOrInsert(
                        ['nim' => $studentData['nim']],
                        [
                            'dim_id' => $studentData['dim_id'] ?? null,
                            'user_id' => $studentData['user_id'] ?? null,
                            'user_name' => $studentData['user_name'] ?? null,
                            'nama' => $studentData['nama'],
                            'email' => $studentData['email'] ?? null,
                            'prodi_id' => $studentData['prodi_id'] ?? null,
                            'prodi_name' => $studentData['prodi_name'],
                            'fakultas' => $studentData['fakultas'] ?? null,
                            'angkatan' => $studentData['angkatan'],
                            'status' => $studentData['status'] ?? 'Aktif',
                            'asrama' => $studentData['asrama'] ?? null,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data mahasiswa ke database: ' . $e->getMessage());
            throw $e;
        }
    }
}

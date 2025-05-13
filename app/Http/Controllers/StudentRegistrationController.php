<?php

namespace App\Http\Controllers;

use App\Models\StudentRegistration;
use App\Models\LocalUser;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StudentRegistrationController extends Controller
{
    /**
     * Tampilkan halaman registrasi untuk event tertentu.
     */
public function create($eventId)
{
    if (!session('user') || session('user')['role'] !== 'mahasiswa') {
        return redirect()->route('events')->with('error', 'Hanya mahasiswa yang sudah login yang dapat mendaftar.');
    }

    $event = Event::findOrFail($eventId);
    return view('register', compact('event'));
}

    /**
     * Proses registrasi pengguna ke event.
     */
public function store(Request $request)
{
    // Validasi input dari formulir
    $validated = $request->validate([
        'event_id' => 'required|exists:events,id',
        'username' => 'required|string|max:20',
        'email' => 'required|email|max:255', // Tambahkan validasi untuk email jika diperlukan
    ]);

    // Coba ambil user dari database lokal
    $user = LocalUser::where('username', $validated['username'])->first();

    // Jika tidak ditemukan di lokal, ambil dari API
    if (!$user) {
        $user = $this->fetchAndStoreUserFromApi($validated['username']);
        if (!$user) {
            return redirect()->back()->withErrors(['msg' => 'Gagal mengambil data pengguna. Silakan coba lagi atau periksa username.']);
        }
    }

    // Periksa apakah role pengguna adalah "mahasiswa"
    if ($user->role !== 'mahasiswa') {
        return redirect()->back()->withErrors(['msg' => 'Hanya mahasiswa yang dapat mendaftar untuk event ini.']);
    }

    // Validasi angkatan pengguna terhadap angkatan_akses event
    $event = Event::findOrFail($validated['event_id']);
    $angkatanAkses = $event->angkatan_akses;
    $angkatanUser = $user->angkatan;

    if ($angkatanAkses) {
        if (strtolower($angkatanAkses) === 'semua') {
            // Semua angkatan diizinkan
        } else {
            $allowedAngkatan = array_map('trim', explode(',', $angkatanAkses));
            if (!$angkatanUser || !in_array($angkatanUser, $allowedAngkatan)) {
                return redirect()->back()->withErrors(['msg' => 'Anda tidak termasuk angkatan yang diperbolehkan mendaftar untuk event ini. Angkatan yang diizinkan: ' . $angkatanAkses]);
            }
        }
    }

    // Simpan registrasi
    $registration = StudentRegistration::create([
        'event_id' => $validated['event_id'],
        'student_name' => $user->nama ?? 'Nama Tidak Ditemukan',
        'username' => $validated['username'],
        'nim' => $user->nim ?? null,
        'angkatan' => $user->angkatan ?? null,
        'prodi' => $user->prodi ?? null,
        'attendance_status' => 'Belum Dikonfirmasi', // Sesuai dengan enum
    ]);

    if (!$registration) {
        return redirect()->back()->withErrors(['msg' => 'Gagal menyimpan registrasi.']);
    }

    return redirect()->route('events')->with('success', 'Pendaftaran berhasil!');
}
    /**
     * Tampilkan daftar semua registrasi dikelompokkan berdasarkan event.
     */
    public function index()
    {
        $registrations = StudentRegistration::all()->groupBy('event_id');
        $events = Event::all()->keyBy('id');
        $participantsByEvent = [];

        foreach ($registrations as $eventId => $eventRegistrations) {
            $participants = [];
            foreach ($eventRegistrations as $registration) {
                $participant = $this->prepareParticipantData($registration);
                $participants[] = $participant;
            }
            $participantsByEvent[$eventId] = $participants;
        }

        return view('admin.partisipan.index', compact('participantsByEvent', 'events'));
    }

    /**
     * Tampilkan daftar partisipan untuk event tertentu.
     */
    public function showParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);
        $registrations = StudentRegistration::where('event_id', $eventId)->get();
        $events = Event::all()->keyBy('id');
        $participants = [];

        foreach ($registrations as $registration) {
            $participants[] = $this->prepareParticipantData($registration);
        }

        return view('admin.partisipan.index', compact('event', 'participants', 'events'));
    }

    /**
     * Perbarui status kehadiran partisipan.
     */
    public function updateAttendance(Request $request, $id)
    {
        $registration = StudentRegistration::findOrFail($id);

        $request->validate([
            'attendance_status' => 'required|in:Hadir,Tidak Hadir,izin,Belum Dikonfirmasi',
        ]);

        if ($registration->update(['attendance_status' => $request->attendance_status])) {
            return redirect()->back()->with('success', 'Status kehadiran berhasil diperbarui!');
        }

        return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui status kehadiran.']);
    }

    
    /**
     * Ekspor data registrasi ke file CSV menggunakan PHP murni
     */
    public function export($eventId = null)
    {
        try {
            // Ambil data registrasi
            $registrations = StudentRegistration::query();
            if ($eventId) {
                $registrations->where('event_id', $eventId);
            }
            $registrations = $registrations->get();

            // Set header untuk unduhan file CSV
            $fileName = 'student_registrations_' . ($eventId ? 'event_' . $eventId : 'all') . '_' . date('Ymd_His') . '.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            // Buka output stream
            $output = fopen('php://output', 'w');

            // Tulis header kolom
            fputcsv($output, [
                'ID',
                'Event ID',
                'Student Name',
                'Username',
                'NIM',
                'Angkatan',
                'Prodi',
                'Attendance Status',
            ]);

            // Tulis data
            foreach ($registrations as $registration) {
                fputcsv($output, [
                    $registration->id,
                    $registration->event_id,
                    $registration->student_name,
                    $registration->username,
                    $registration->nim,
                    $registration->angkatan,
                    $registration->prodi,
                    $registration->attendance_status,
                ]);
            }

            // Tutup output stream
            fclose($output);
            exit();

        } catch (\Exception $e) {
            Log::error('Failed to export student registrations', [
                'event_id' => $eventId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors(['msg' => 'Gagal mengekspor data: ' . $e->getMessage()]);
        }
    }


    /**
     * Ambil data pengguna dari API dan simpan ke local_users jika berhasil.
     */
    private function fetchAndStoreUserFromApi($username)
    {
        try {
            $token = session('token');
            if (!$token) {
                return null;
            }

            $response = Http::withToken($token)->get(
                'https://cis.del.ac.id/api/library-api/mahasiswa?username=' . $username . '&status=Aktif'
            );

            if ($response->successful()) {
                $apiData = $response->json();
                $mahasiswa = $apiData['data']['mahasiswa'][0] ?? null;

                if ($mahasiswa) {
                    return LocalUser::create([
                        'username' => $username,
                        'nama' => $mahasiswa['nama'] ?? 'Nama Tidak Ditemukan',
                        'nim' => $mahasiswa['nim'] ?? null,
                        'angkatan' => $mahasiswa['angkatan'] ?? null,
                        'prodi' => $mahasiswa['prodi_name'] ?? null,
                        'role' => 'mahasiswa',
                        'password' => bcrypt('default_password'),
                    ]);
                }
            } else {
                Log::warning('API Request Failed', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('API Exception', ['message' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Siapkan data partisipan dengan fallback dari API atau local_users.
     */
    private function prepareParticipantData($registration)
    {
        $participant = [
            'id' => $registration->id,
            'username' => $registration->username ?? '-',
            'nama' => $registration->student_name ?? '-',
            'nim' => $registration->nim ?? '-',
            'angkatan' => $registration->angkatan ?? '-',
            'prodi' => $registration->prodi ?? '-',
            'attendance_status' => $registration->attendance_status ?? 'Belum Dikonfirmasi',
        ];

        try {
            $token = session('token');
            if ($token) {
                $response = Http::withToken($token)->get(
                    'https://cis.del.ac.id/api/library-api/mahasiswa?username=' . $registration->username . '&status=Aktif'
                );

                if ($response->successful()) {
                    $apiData = $response->json();
                    $mahasiswa = $apiData['data']['mahasiswa'][0] ?? null;

                    if ($mahasiswa) {
                        $participant['nama'] = $mahasiswa['nama'] ?? $registration->student_name;
                        $participant['nim'] = $mahasiswa['nim'] ?? '-';
                        $participant['angkatan'] = $mahasiswa['angkatan'] ?? '-';
                        $participant['prodi'] = $mahasiswa['prodi_name'] ?? '-';

                        // Update local_users tanpa mengubah password atau remember_token
                        LocalUser::updateOrCreate(
                            ['username' => $registration->username],
                            [
                                'nama' => $mahasiswa['nama'] ?? $registration->student_name,
                                'nim' => $mahasiswa['nim'] ?? null,
                                'angkatan' => $mahasiswa['angkatan'] ?? null,
                                'prodi' => $mahasiswa['prodi_name'] ?? null,
                                'role' => LocalUser::where('username', $registration->username)->value('role') ?? 'mahasiswa',
                            ]
                        );

                        // Update student_registrations dengan data terbaru dari API
                        $registration->update([
                            'student_name' => $mahasiswa['nama'] ?? $registration->student_name,
                            'nim' => $mahasiswa['nim'] ?? $registration->nim,
                            'angkatan' => $mahasiswa['angkatan'] ?? $registration->angkatan,
                            'prodi' => $mahasiswa['prodi_name'] ?? $registration->prodi,
                        ]);
                    }
                } else {
                    $this->fallbackToLocalUser($registration, $participant);
                }
            } else {
                $this->fallbackToLocalUser($registration, $participant);
            }
        } catch (\Exception $e) {
            $this->fallbackToLocalUser($registration, $participant);
            Log::error('Exception in API Call', ['message' => $e->getMessage()]);
        }

        return $participant;
    }

    /**
     * Gunakan data dari local_users sebagai fallback.
     */
    private function fallbackToLocalUser($registration, &$participant)
    {
        $localUser = LocalUser::where('username', $registration->username)->first();
        if ($localUser) {
            $participant['nama'] = $localUser->nama ?? $registration->student_name;
            $participant['nim'] = $localUser->nim ?? '-';
            $participant['angkatan'] = $localUser->angkatan ?? '-';
            $participant['prodi'] = $localUser->prodi ?? '-';

            // Update student_registrations dengan data dari LocalUser
            $registration->update([
                'student_name' => $localUser->nama ?? $registration->student_name,
                'nim' => $localUser->nim ?? $registration->nim,
                'angkatan' => $localUser->angkatan ?? $registration->angkatan,
                'prodi' => $localUser->prodi ?? $registration->prodi,
            ]);
        } else {
            $participant['nama'] = '(Gagal ambil dari API)';
        }
    }

    /**
     * Buat email fallback berdasarkan username.
     */
    private function generateFallbackEmail($username)
    {
        return "{$username}@example.com";
    }
}
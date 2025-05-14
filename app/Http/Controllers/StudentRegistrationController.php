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
    public function create($eventId)
    {
        if (!session('user') || session('user')['role'] !== 'mahasiswa') {
            return redirect()->route('events')->with('error', 'Hanya mahasiswa yang sudah login yang dapat mendaftar.');
        }

        $event = Event::findOrFail($eventId);
        return view('register', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'username' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $user = LocalUser::where('username', $validated['username'])->first() ?? $this->fetchAndStoreUserFromApi($validated['username']);

        if (!$user) {
            return redirect()->back()->withErrors(['msg' => 'Gagal mengambil data pengguna. Silakan coba lagi atau periksa username.']);
        }

        if ($user->role !== 'mahasiswa') {
            return redirect()->back()->withErrors(['msg' => 'Hanya mahasiswa yang dapat mendaftar untuk event ini.']);
        }

        $event = Event::findOrFail($validated['event_id']);
        if ($event->angkatan_akses && strtolower($event->angkatan_akses) !== 'semua') {
            $allowedAngkatan = array_map('trim', explode(',', $event->angkatan_akses));
            if (!$user->angkatan || !in_array($user->angkatan, $allowedAngkatan)) {
                return redirect()->back()->withErrors(['msg' => 'Anda tidak termasuk angkatan yang diperbolehkan mendaftar. Angkatan yang diizinkan: ' . $event->angkatan_akses]);
            }
        }

        $registration = StudentRegistration::create([
            'event_id' => $validated['event_id'],
            'student_name' => $user->nama,
            'username' => $validated['username'],
            'nim' => $user->nim,
            'angkatan' => $user->angkatan,
            'prodi' => $user->prodi,
            'attendance_status' => 'Belum Dikonfirmasi',
        ]);

        if (!$registration) {
            return redirect()->back()->withErrors(['msg' => 'Gagal menyimpan registrasi.']);
        }

        return redirect()->route('events')->with('success', 'Pendaftaran berhasil!');
    }

    public function index()
    {
        $registrations = StudentRegistration::all()->groupBy('event_id');
        $events = Event::all()->keyBy('id');

        $participantsByEvent = [];
        foreach ($registrations as $eventId => $eventRegistrations) {
            $participantsByEvent[$eventId] = $eventRegistrations->map(fn($r) => $this->prepareParticipantData($r));
        }

        return view('admin.partisipan.index', compact('participantsByEvent', 'events'));
    }

    public function showParticipants($eventId)
    {
        $event = Event::findOrFail($eventId);
        $registrations = StudentRegistration::where('event_id', $eventId)->get();
        $events = Event::all()->keyBy('id');

        $participants = $registrations->map(fn($r) => $this->prepareParticipantData($r));

        return view('admin.partisipan.index', compact('event', 'participants', 'events'));
    }

    public function updateAttendance(Request $request, $id)
    {
        $request->validate([
            'attendance_status' => 'required|in:Hadir,Tidak Hadir,izin,Belum Dikonfirmasi',
        ]);

        $registration = StudentRegistration::findOrFail($id);
        $registration->attendance_status = $request->attendance_status;

        if ($registration->save()) {
            return redirect()->back()->with('success', 'Status kehadiran berhasil diperbarui!');
        }

        return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui status kehadiran.']);
    }

    public function export($eventId = null)
    {
        try {
            $query = StudentRegistration::query();
            if ($eventId) $query->where('event_id', $eventId);
            $registrations = $query->get();

            $fileName = 'student_registrations_' . ($eventId ? 'event_' . $eventId : 'all') . '_' . now()->format('Ymd_His') . '.csv';

            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=$fileName");
            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Event ID', 'Student Name', 'Username', 'NIM', 'Angkatan', 'Prodi', 'Attendance Status']);

            foreach ($registrations as $r) {
                fputcsv($output, [$r->id, $r->event_id, $r->student_name, $r->username, $r->nim, $r->angkatan, $r->prodi, $r->attendance_status]);
            }

            fclose($output);
            exit;

        } catch (\Exception $e) {
            Log::error('Failed to export student registrations', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['msg' => 'Gagal mengekspor data: ' . $e->getMessage()]);
        }
    }

    private function fetchAndStoreUserFromApi($username)
    {
        try {
            $token = session('token');
            if (!$token) return null;

            $response = Http::withToken($token)->get("https://cis.del.ac.id/api/library-api/mahasiswa?username=$username&status=Aktif");

            if ($response->successful()) {
                $data = $response->json()['data']['mahasiswa'][0] ?? null;
                if ($data) {
                    return LocalUser::create([
                        'username' => $username,
                        'nama' => $data['nama'] ?? 'Nama Tidak Ditemukan',
                        'nim' => $data['nim'] ?? null,
                        'angkatan' => $data['angkatan'] ?? null,
                        'prodi' => $data['prodi_name'] ?? null,
                        'role' => 'mahasiswa',
                        'password' => bcrypt('default_password'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('API Exception', ['message' => $e->getMessage()]);
        }

        return null;
    }

    private function prepareParticipantData($registration)
    {
        $participant = [
            'id' => $registration->id,
            'username' => $registration->username,
            'nama' => $registration->student_name,
            'nim' => $registration->nim,
            'angkatan' => $registration->angkatan,
            'prodi' => $registration->prodi,
            'attendance_status' => $registration->attendance_status,
        ];

        try {
            $token = session('token');
            if ($token) {
                $response = Http::withToken($token)->get("https://cis.del.ac.id/api/library-api/mahasiswa?username={$registration->username}&status=Aktif");

                if ($response->successful()) {
                    $mhs = $response->json()['data']['mahasiswa'][0] ?? null;
                    if ($mhs) {
                        $participant['nama'] = $mhs['nama'] ?? $registration->student_name;
                        $participant['nim'] = $mhs['nim'] ?? $registration->nim;
                        $participant['angkatan'] = $mhs['angkatan'] ?? $registration->angkatan;
                        $participant['prodi'] = $mhs['prodi_name'] ?? $registration->prodi;

                        LocalUser::updateOrCreate([
                            'username' => $registration->username
                        ], [
                            'nama' => $mhs['nama'] ?? $registration->student_name,
                            'nim' => $mhs['nim'] ?? $registration->nim,
                            'angkatan' => $mhs['angkatan'] ?? $registration->angkatan,
                            'prodi' => $mhs['prodi_name'] ?? $registration->prodi,
                            'role' => LocalUser::where('username', $registration->username)->value('role') ?? 'mahasiswa'
                        ]);

                        $registration->update($participant);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Participant Data Fallback', ['message' => $e->getMessage()]);
            $this->fallbackToLocalUser($registration, $participant);
        }

        return $participant;
    }

    private function fallbackToLocalUser($registration, &$participant)
    {
        $local = LocalUser::where('username', $registration->username)->first();
        if ($local) {
            $participant['nama'] = $local->nama ?? $registration->student_name;
            $participant['nim'] = $local->nim ?? $registration->nim;
            $participant['angkatan'] = $local->angkatan ?? $registration->angkatan;
            $participant['prodi'] = $local->prodi ?? $registration->prodi;

            $registration->update($participant);
        }
    }
}

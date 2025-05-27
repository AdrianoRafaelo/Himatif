<?php

namespace App\Http\Controllers;

use App\Models\StudentRegistration;
use App\Models\LocalUser;
use App\Models\CampusStudent;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class StudentRegistrationController extends Controller
{
    public function index(Request $request)
    {
        if (!session('user') || session('user')['role'] !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai admin.');
        }

        $query = StudentRegistration::with('event');
        if ($request->has('event_id') && $request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();
        $events = Event::all(); // Pastikan $events di-load dari model Event

        Log::info('Jumlah partisipan dimuat di index', [
            'count' => $registrations->count(),
            'event_id_filter' => $request->event_id ?? 'Semua',
        ]);

        return view('admin.partisipan.index', compact('registrations', 'events'));
    }

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
        if (!session('user') || session('user')['role'] !== 'mahasiswa') {
            return redirect()->route('events')->with('error', 'Hanya mahasiswa yang dapat mendaftar.');
        }

        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $userData = session('user');
        $user = LocalUser::where('username', $userData['username'])->first();

        if (!$user) {
            $student = CampusStudent::where('user_name', $userData['username'])
                ->orWhere('nim', $userData['username'])
                ->first();

            if (!$student) {
                Log::warning('Data mahasiswa tidak ditemukan', ['username' => $userData['username']]);
                return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            }

            $user = LocalUser::create([
                'username' => $student->user_name ?? $student->nim,
                'nama' => $student->nama ?? 'Tidak diketahui',
                'nim' => $student->nim ?? null,
                'angkatan' => $student->angkatan ?? null,
                'prodi' => $student->prodi_name ?? null,
                'email' => $student->email ?? null,
                'role' => 'mahasiswa',
                'password' => bcrypt('default_password'),
            ]);
        }

        $event = Event::findOrFail($request->event_id);

        if (StudentRegistration::where('event_id', $event->id)->where('username', $user->username)->exists()) {
            Log::info('Mahasiswa sudah terdaftar pada event', [
                'username' => $user->username,
                'event_id' => $event->id,
            ]);
            return redirect()->back()->with('error', 'Anda sudah terdaftar pada event ini.');
        }

        if ($event->angkatan_akses && $event->angkatan_akses !== 'all') {
            $allowed = array_map('intval', explode(',', $event->angkatan_akses));
            if (!in_array($user->angkatan, $allowed)) {
                Log::info('Angkatan tidak diizinkan untuk mendaftar', [
                    'username' => $user->username,
                    'angkatan' => $user->angkatan,
                    'allowed_angkatan' => $allowed,
                ]);
                return redirect()->back()->with('error', 'Angkatan Anda tidak diizinkan mendaftar untuk event ini.');
            }
        }

        $registrationData = [
            'event_id' => $event->id,
            'student_name' => $user->nama,
            'username' => $user->username,
            'nim' => $user->nim,
            'angkatan' => $user->angkatan,
            'email' => $user->email,
            'prodi' => $user->prodi,
            'hadir' => true,
            'tidak_hadir' => false,
        ];

        $registration = StudentRegistration::create($registrationData);

        if ($registration) {
            Log::info('Mahasiswa berhasil mendaftar secara manual', [
                'username' => $user->username,
                'event_id' => $event->id,
                'registration_id' => $registration->id,
                'hadir' => $registration->hadir,
                'tidak_hadir' => $registration->tidak_hadir,
            ]);
        } else {
            Log::error('Gagal menyimpan pendaftaran mahasiswa', [
                'username' => $user->username,
                'event_id' => $event->id,
            ]);
            return redirect()->back()->with('error', 'Gagal mendaftar. Silakan coba lagi.');
        }

        return redirect()->route('events')->with('success', 'Pendaftaran berhasil dengan status hadir!');
    }

    public function showParticipants($eventId)
    {
        if (!session('user') || session('user')['role'] !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai admin.');
        }

        $event = Event::findOrFail($eventId);
        $registrations = StudentRegistration::where('event_id', $eventId)->get();
        $events = Event::all(); // Pastikan $events tersedia untuk konsistensi
        Log::info('Jumlah partisipan dimuat di showParticipants', ['count' => $registrations->count()]);

        return view('admin.partisipan.show', compact('event', 'registrations', 'events'));
    }

    public function updateAttendance(Request $request, $id)
    {
        $request->validate([
            'attendance_status' => 'required|in:1,2',
        ]);

        $registration = StudentRegistration::findOrFail($id);
        $registration->update([
            'hadir' => $request->attendance_status == 1,
            'tidak_hadir' => $request->attendance_status == 2,
        ]);

        Log::info('Status kehadiran diperbarui', [
            'registration_id' => $id,
            'hadir' => $request->attendance_status == 1,
            'tidak_hadir' => $request->attendance_status == 2,
        ]);

        return redirect()->back()->with('success', 'Status kehadiran diperbarui.');
    }

    public function updateAttendanceBulk(Request $request)
    {
        $request->validate([
            'registration_ids' => 'required|array',
            'attendance_status.*' => 'in:1',
        ]);

        $registrationIds = $request->input('registration_ids');
        $attendanceStatuses = $request->input('attendance_status', []);

        $updatedCount = 0;
        foreach ($registrationIds as $id) {
            $registration = StudentRegistration::findOrFail($id);
            $isPresent = isset($attendanceStatuses[$id]);
            $registration->update([
                'hadir' => $isPresent,
                'tidak_hadir' => !$isPresent,
            ]);
            $updatedCount++;
        }

        Log::info('Status kehadiran diperbarui secara massal', ['updated_count' => $updatedCount]);

        return redirect()->back()->with('success', 'Status kehadiran untuk semua partisipan telah diperbarui.');
    }

    public function export($eventId = null)
    {
        $query = StudentRegistration::with('event');
        if ($eventId) {
            $query->where('event_id', $eventId);
        }

        $registrations = $query->get();

        $csvContent = "Nama,Email,NIM,Angkatan,Prodi,Event,Status Kehadiran\n";
        foreach ($registrations as $r) {
            $email = LocalUser::where('username', $r->username)->first()->email ?? '-';
            $status = $r->hadir ? 'Hadir' : 'Tidak Hadir';
            $csvContent .= "\"{$r->student_name}\",\"{$email}\",\"{$r->nim}\",\"{$r->angkatan}\",\"{$r->prodi}\",\"{$r->event->name}\",\"{$status}\"\n";
        }

        Log::info('Data partisipan diekspor ke CSV', ['event_id' => $eventId, 'total_records' => $registrations->count()]);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="registrations.csv"',
        ]);
    }
}

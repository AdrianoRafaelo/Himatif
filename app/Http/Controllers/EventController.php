<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Proker;
use App\Models\Proposal;
use App\Models\StudentRegistration;
use App\Models\LocalUser;
use App\Models\CampusStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        if (!session('user') || session('user')['role'] !== 'admin') {
            return redirect('/')->withErrors('Anda tidak punya akses sebagai admin.');
        }

        $scheduledEvents = Event::where('status', 'scheduled')
            ->with(['proker', 'proposal'])
            ->orderBy('created_at', 'desc')
            ->get();

        $completedEvents = Event::where('status', 'completed')
            ->with(['proker', 'proposal'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.event.index', compact('scheduledEvents', 'completedEvents'));
    }

    public function showParticipants(Event $event)
    {
        if (!session('user') || session('user')['role'] !== 'admin') {
            return redirect('/')->withErrors('Anda tidak punya akses sebagai admin.');
        }

        $registrations = StudentRegistration::where('event_id', $event->id)->get();
        return view('admin.partisipan.index', compact('event', 'registrations'));
    }

    public function indexUser()
    {
        $scheduledEvents = Event::where('status', 'scheduled')
            ->orderBy('created_at', 'desc')
            ->get();

        $completedEvents = Event::where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelledEvents = Event::where('status', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('events', compact('scheduledEvents', 'completedEvents', 'cancelledEvents'));
    }

    public function create()
    {
        $prokers = Proker::all();
        $proposals = Proposal::where('status', 'approved')->get();
        return view('admin.event.create', compact('prokers', 'proposals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proker_id' => 'required|exists:prokers,id',
            'proposal_id' => 'nullable|exists:proposals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
            'notes' => 'nullable|string',
            'banner_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'angkatan_akses' => 'required_without:semua_angkatan|string|regex:/^(\d{4}(,\d{4})*)$/',
            'semua_angkatan' => 'nullable|boolean',
        ], [
            'angkatan_akses.required_without' => 'Angkatan yang Bisa Mendaftar wajib diisi jika tidak memilih Semua Angkatan.',
            'angkatan_akses.regex' => 'Format Angkatan yang Bisa Mendaftar harus berupa tahun (contoh: 2021,2022,2023).',
        ]);

        $data = $request->all();

        if ($request->has('semua_angkatan')) {
            $data['angkatan_akses'] = 'all';
        } elseif (empty($data['angkatan_akses'])) {
            $data['angkatan_akses'] = null;
        }

        if ($request->hasFile('banner_path')) {
            $data['banner_path'] = $request->file('banner_path')->store('banners', 'public');
        }

        $event = Event::create($data);

        // Pendaftaran otomatis hanya jika angkatan_akses bukan 'all'
        if ($data['angkatan_akses'] && $data['angkatan_akses'] !== 'all') {
            try {
                // Ambil data mahasiswa dari tabel campus_students
                $allowedAngkatan = explode(',', $data['angkatan_akses']);
                $mahasiswa = CampusStudent::whereIn('angkatan', $allowedAngkatan)
                    ->where('prodi_name', 'DIII Teknologi Informasi')
                    ->where('status', 'Aktif')
                    ->get();

                Log::info('Jumlah mahasiswa yang diambil dari campus_students untuk pendaftaran otomatis: ' . count($mahasiswa));

                if ($mahasiswa->isEmpty()) {
                    Log::warning('Tidak ada mahasiswa yang ditemukan untuk angkatan: ' . $data['angkatan_akses']);
                    return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan, tetapi tidak ada mahasiswa yang ditemukan untuk angkatan tersebut.');
                }

                foreach ($mahasiswa as $mhs) {
                    StudentRegistration::updateOrCreate(
                        [
                            'event_id' => $event->id,
                            'username' => $mhs->user_name ?? $mhs->nim,
                        ],
                        [
                            'student_name' => $mhs->nama ?? 'Tidak diketahui',
                            'nim' => $mhs->nim ?? null,
                            'angkatan' => $mhs->angkatan ?? null,
                            'email' => $mhs->email ?? null,
                            'prodi' => $mhs->prodi_name ?? null,
                            'hadir' => false,
                            'tidak_hadir' => false,
                        ]
                    );

                    LocalUser::updateOrCreate(
                        ['username' => $mhs->user_name ?? $mhs->nim],
                        [
                            'nama' => $mhs->nama ?? 'Tidak diketahui',
                            'nim' => $mhs->nim ?? null,
                            'angkatan' => $mhs->angkatan ?? null,
                            'prodi' => $mhs->prodi_name ?? null,
                            'email' => $mhs->email ?? null,
                            'role' => 'mahasiswa',
                            'password' => bcrypt('default_password'),
                        ]
                    );
                }

                Log::info('Event berhasil dibuat dan mahasiswa didaftarkan', [
                    'event_id' => $event->id,
                    'registered_count' => count($mahasiswa),
                    'angkatan_akses' => $data['angkatan_akses'],
                ]);

                return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan dan ' . count($mahasiswa) . ' mahasiswa didaftarkan ke daftar hadir.');
            } catch (\Exception $e) {
                Log::error('Gagal mendaftarkan mahasiswa untuk event', [
                    'event_id' => $event->id,
                    'error' => $e->getMessage()
                ]);
                return redirect()->route('admin.event.index')->withErrors(['error' => 'Event dibuat, tetapi gagal mendaftarkan mahasiswa: ' . $e->getMessage()]);
            }
        }

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        $prokers = Proker::all();
        $proposals = Proposal::where('status', 'approved')
            ->when($event->proposal_id, function ($query) use ($event) {
                return $query->orWhere('id', $event->proposal_id);
            })
            ->get();
        return view('admin.event.edit', compact('event', 'prokers', 'proposals'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'proker_id' => 'required|exists:prokers,id',
            'proposal_id' => 'nullable|exists:proposals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
            'notes' => 'nullable|string',
            'banner_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'angkatan_akses' => 'required_without:semua_angkatan|string|regex:/^(\d{4}(,\d{4})*)$/',
            'semua_angkatan' => 'nullable|boolean',
        ], [
            'angkatan_akses.required_without' => 'Angkatan yang Bisa Mendaftar wajib diisi jika tidak memilih Semua Angkatan.',
            'angkatan_akses.regex' => 'Format Angkatan yang Bisa Mendaftar harus berupa tahun (contoh: 2021,2022,2023).',
        ]);

        $data = $request->all();

        if ($request->has('semua_angkatan')) {
            $data['angkatan_akses'] = 'all';
        } elseif (empty($data['angkatan_akses'])) {
            $data['angkatan_akses'] = null;
        }

        if ($request->hasFile('banner_path')) {
            if ($event->banner_path) {
                Storage::disk('public')->delete($event->banner_path);
            }
            $data['banner_path'] = $request->file('banner_path')->store('banners', 'public');
        }

        $event->update($data);
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->banner_path) {
            Storage::disk('public')->delete($event->banner_path);
        }
        $event->delete();
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil dihapus.');
    }
}

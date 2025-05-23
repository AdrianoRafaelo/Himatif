<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Proker;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['proker', 'proposal'])->get();
        return view('admin.event.index', compact('events'));
    }
    public function indexUser()
    {

        $events = Event::all(); 
        return view('events', compact('events'));
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
            'angkatan_akses' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('banner_path')) {
            $data['banner_path'] = $request->file('banner_path')->store('banners', 'public');
        }

        Event::create($data);
        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        $prokers = Proker::all();
        // Ambil proposal yang disetujui, dan jika event memiliki proposal_id, sertakan proposal tersebut
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
            'angkatan_akses' => 'nullable|string|max:255',
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
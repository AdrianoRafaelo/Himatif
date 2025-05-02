<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Proker;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Menampilkan daftar event
    public function index()
    {
        $events = Event::with(['proker', 'proposal'])
                     ->latest()
                     ->get();
                     
        return view('admin.event.index', compact('events'));
    }

    // Menampilkan form create
    public function create()
    {
        $prokers = Proker::all();
        $proposals = Proposal::where('status', 'approved')->get();
        
        return view('admin.event.create', compact('prokers', 'proposals'));
    }

    // Menyimpan event baru dengan foto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proker_id' => 'required|exists:prokers,id',
            'proposal_id' => 'nullable|exists:proposals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Upload foto banner
        $bannerPath = $request->file('banner')->store('events/banners', 'public');
        $validated['banner_path'] = $bannerPath;

        Event::create($validated);

        return redirect()->route('admin.event.index')
                        ->with('success', 'Event berhasil dibuat.');
    }

    // Menampilkan detail event
    public function show(Event $event)
    {
        return view('admin.event.show', compact('event'));
    }

    // Menampilkan form edit
    public function edit(Event $event)
    {
        $prokers = Proker::all();
        $proposals = Proposal::where('status', 'approved')->get();
        
        return view('admin.event.edit', compact('event', 'prokers', 'proposals'));
    }

    // Update event
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'proker_id' => 'required|exists:prokers,id',
            'proposal_id' => 'nullable|exists:proposals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,scheduled,completed,cancelled',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Handle upload foto baru jika ada
        if ($request->hasFile('banner')) {
            // Hapus foto lama jika ada
            if ($event->banner_path) {
                Storage::disk('public')->delete($event->banner_path);
            }
            
            // Simpan foto baru
            $bannerPath = $request->file('banner')->store('events/banners', 'public');
            $validated['banner_path'] = $bannerPath;
        }

        $event->update($validated);

        return redirect()->route('admin.event.index')
                        ->with('success', 'Event berhasil diperbarui.');
    }

    // Hapus event
    public function destroy(Event $event)
    {
        // Hapus foto jika ada
        if ($event->banner_path) {
            Storage::disk('public')->delete($event->banner_path);
        }
        
        $event->delete();
        
        return redirect()->route('admin.event.index')
                        ->with('success', 'Event berhasil dihapus.');
    }

    public function tampilEventKePengguna()
    {
        $events = Event::with('proker')->latest()->get();
        return view('event', compact('events'));
    }

    

}
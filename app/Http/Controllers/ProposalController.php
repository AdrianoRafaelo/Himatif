<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Proker;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    // Halaman admin: melihat semua proposal
    public function index()
    {
        $proposals = Proposal::with('proker')->latest()->get();
        return view('admin.proposals.index', compact('proposals'));
    }

    // Form admin untuk kirim proposal
    public function create()
    {
        $prokers = Proker::all();
        return view('admin.proposals.create', compact('prokers'));
    }

    // Simpan proposal baru dari admin
    public function store(Request $request)
    {
        $request->validate([
            'proker_id'   => 'required|exists:prokers,id',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file')->store('proposals', 'public');

        Proposal::create([
            'proker_id'   => $request->proker_id,
            'title'       => $request->title,
            'description' => $request->description,
            'file_path'   => $filePath,
            'status'      => 'pending', // default status
            'sent_at'     => now(),
        ]);

        return redirect()->route('admin.proposals.index')->with('success', 'Proposal berhasil dikirim.');
    }

    // Halaman kaprodi: melihat semua proposal masuk
    public function kaprodiIndex()
    {
        $proposals = Proposal::with('proker')->latest()->get();
        return view('kaprodi.proposals.index', compact('proposals'));
    }

    // Kaprodi menyetujui proposal
    public function approve(Proposal $proposal)
    {
        $proposal->update([
            'status'      => 'approved',
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Proposal disetujui.');
    }

    // Kaprodi menolak proposal
    public function reject(Proposal $proposal)
    {
        $proposal->update([
            'status'      => 'rejected',
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Proposal ditolak.');
    }
}

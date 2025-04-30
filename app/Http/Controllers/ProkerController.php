<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProkerController extends Controller
{
    // Tampilkan semua proker
    public function index()
    {
        $prokers = Proker::with('creator')->latest()->get();
        return view('admin.proker.index', compact('prokers'));
    }

    // Tampilkan form buat proker
    public function create()
    {
        return view('admin.proker.create');
    }

    // Simpan proker baru
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'location' => 'nullable|string',
            'planned_date' => 'nullable|date',
            'actual_date' => 'nullable|date',
            'funding_source' => 'nullable|string',
            'planned_budget' => 'nullable|numeric',
            'actual_budget' => 'nullable|numeric',
            'status' => 'nullable|string',
            'period' => 'nullable|string',
        ]);
        
        Proker::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'objective' => $request->objective,
            'location' => $request->location,
            'planned_date' => $request->planned_date,
            'actual_date' => $request->actual_date,
            'funding_source' => $request->funding_source,
            'planned_budget' => $request->planned_budget,
            'actual_budget' => $request->actual_budget,
            'status' => $request->status,
            'period' => $request->period,
            'created_by' => Auth::id(),
        ]);
        
        // Fixed route name to match your actual route
        return redirect()->route('proker.index')->with('success', 'Proker berhasil dibuat.');
    }

    // Tampilkan form edit proker
    public function edit($id)
    {
        $proker = Proker::findOrFail($id);
        return view('admin.proker.edit', compact('proker'));
    }

    // Update proker
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'location' => 'nullable|string',
            'planned_date' => 'nullable|date',
            'actual_date' => 'nullable|date',
            'funding_source' => 'nullable|string',
            'planned_budget' => 'nullable|numeric',
            'actual_budget' => 'nullable|numeric',
            'status' => 'nullable|string',
            'period' => 'nullable|string',
        ]);

        $proker = Proker::findOrFail($id);
        $proker->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'objective' => $request->objective,
            'location' => $request->location,
            'planned_date' => $request->planned_date,
            'actual_date' => $request->actual_date,
            'funding_source' => $request->funding_source,
            'planned_budget' => $request->planned_budget,
            'actual_budget' => $request->actual_budget,
            'status' => $request->status,
            'period' => $request->period,
        ]);

        // Fixed route name to match your actual route
        return redirect()->route('proker.index')->with('success', 'Proker berhasil diupdate.');
    }

    // Hapus proker
    public function destroy($id)
    {
        $proker = Proker::findOrFail($id);
        $proker->delete();

        // Fixed route name to match your actual route
        return redirect()->route('proker.index')->with('success', 'Proker berhasil dihapus.');
    }
}
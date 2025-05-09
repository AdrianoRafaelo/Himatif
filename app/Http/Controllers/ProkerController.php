<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\Bph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProkerController extends Controller
{
    public function index()
    {
        $prokers = Proker::with('creator')->latest()->paginate(10);
        return view('admin.proker.index', compact('prokers'));
    }

    public function create()
    {
        $periods = Bph::select('period')->distinct()->pluck('period')->sort()->values();
        return view('admin.proker.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'location' => 'nullable|string',
            'planned_date' => 'nullable|string',
            'actual_date' => 'nullable|date',
            'funding_source' => 'nullable|string',
            'planned_budget' => 'nullable|numeric',
            'actual_budget' => 'nullable|numeric',
            'status' => 'nullable|string|in:Perencanaan,Persiapan,Pelaksanaan,Selesai',
            'period' => 'required|string|regex:/^\d{4}-\d{4}$/',
        ]);

        $periodExists = Bph::where('period', $request->period)->exists();
        if (!$periodExists) {
            return redirect()->back()->with('error', 'Periode tidak valid. Pilih periode yang sudah memiliki anggota BPH.');
        }

        $plannedDate = $request->planned_date ? $request->planned_date . '-01' : null;

        if ($plannedDate && $request->actual_date && $request->actual_date < $plannedDate) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['actual_date' => 'Tanggal realisasi tidak boleh lebih awal dari tanggal rencana.']);
        }
        
        Proker::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'objective' => $request->objective,
            'location' => $request->location,
            'planned_date' => $plannedDate,
            'actual_date' => $request->actual_date,
            'funding_source' => $request->funding_source,
            'planned_budget' => $request->planned_budget,
            'actual_budget' => $request->actual_budget,
            'status' => $request->status ?? 'Perencanaan',
            'period' => $request->period,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('proker.index')->with('success', 'Proker berhasil dibuat.');
    }

    public function edit($id)
    {
        $proker = Proker::findOrFail($id);
        $periods = Bph::select('period')->distinct()->pluck('period')->sort()->values();
        return view('admin.proker.edit', compact('proker', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $proker = Proker::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'location' => 'nullable|string',
            'planned_date' => 'nullable|string',
            'actual_date' => 'nullable|date',
            'funding_source' => 'nullable|string',
            'planned_budget' => 'nullable|numeric',
            'actual_budget' => 'nullable|numeric',
            'status' => 'nullable|string|in:Perencanaan,Persiapan,Pelaksanaan,Selesai',
            'period' => 'required|string|regex:/^\d{4}-\d{4}$/',
        ]);

        $periodExists = Bph::where('period', $request->period)->exists();
        if (!$periodExists) {
            return redirect()->back()->with('error', 'Periode tidak valid. Pilih periode yang sudah memiliki anggota BPH.');
        }

        $plannedDate = $request->planned_date ? $request->planned_date . '-01' : null;

        $proker->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'objective' => $request->objective,
            'location' => $request->location,
            'planned_date' => $plannedDate,
            'actual_date' => $request->actual_date,
            'funding_source' => $request->funding_source,
            'planned_budget' => $request->planned_budget,
            'actual_budget' => $request->actual_budget,
            'status' => $request->status,
            'period' => $request->period,
        ]);

        return redirect()->route('proker.index')->with('success', 'Proker berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $proker = Proker::findOrFail($id);
        $proker->delete();
        return redirect()->route('proker.index')->with('success', 'Proker berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class ProgramKerjaController extends Controller
{
    public function index()
    {
        $programs = ProgramKerja::all();
        return view('admin.proker.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.proker.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        ProgramKerja::create($request->all());

        return redirect()->route('proker.index')->with('success', 'Program kerja berhasil ditambahkan');
    }

    public function show(ProgramKerja $programKerja)
    {
        return view('proker.show', compact('programKerja'));
    }

    public function update(Request $request, ProgramKerja $programKerja)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $programKerja->update($request->all());

        return redirect()->route('admin.proker.index')->with('success', 'Program kerja berhasil diupdate');
    }

    public function destroy(ProgramKerja $programKerja)
    {
        $programKerja->delete();

        return redirect()->route('proker.index')->with('success', 'Program kerja berhasil dihapus');
    }
}

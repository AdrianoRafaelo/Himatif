<?php

namespace App\Http\Controllers;

use App\Models\Tentang;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index()
    {
        $data = Tentang::latest()->get();
        return view('admin.tentang.index', compact('data'));
    }

    public function create()
    {
        return view('admin.tentang.create', ['tentang' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'konten' => 'required'
        ]);

        Tentang::create($request->only('konten'));
        return redirect()->route('admin.tentang.index')->with('success', 'Berhasil disimpan!');
    }

    public function show($id)
    {
        $tentang = Tentang::findOrFail($id);
        return view('admin.tentang.show', compact('tentang'));
    }

    public function edit($id)
    {
        $tentang = Tentang::findOrFail($id);
        return view('admin.tentang.create', compact('tentang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'konten' => 'required'
        ]);

        $tentang = Tentang::findOrFail($id);
        $tentang->update($request->only('konten'));

        return redirect()->route('admin.tentang.index')->with('success', 'Berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tentang = Tentang::findOrFail($id);
        $tentang->delete();

        return back()->with('success', 'Data dihapus.');
    }

    public function visi()
{
    // Ambil data terbaru dari tabel Tentang
    $data = Tentang::latest()->get();
    // Kirim data ke tampilan 'tentang.blade.php'
    return view('tentang', compact('data'));
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriController extends Controller
{
    // Tampilkan semua data galeri
    public function index()
    {
        $galeris = Galeri::all();
        return view('admin.galeri.index', compact('galeris'));
    }

    // Tampilkan form untuk menambah galeri baru
    public function create()
    {
        return view('admin.galeri.create');
    }

    // Simpan data galeri baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $galeri = new Galeri();
        $galeri->judul = $request->judul;
        $galeri->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galeri'), $filename);
            $galeri->gambar = $filename;
        }

        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan!');
    }

    // Tampilkan form untuk mengedit galeri
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    // Hapus data galeri
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus gambar fisik jika ada
        if ($galeri->gambar && file_exists(public_path('uploads/galeri/' . $galeri->gambar))) {
            unlink(public_path('uploads/galeri/' . $galeri->gambar));
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus!');
    }


    // Simpan perubahan dari galeri
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $galeri = Galeri::findOrFail($id);
        $galeri->judul = $request->judul;
        $galeri->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galeri'), $filename);
            $galeri->gambar = $filename;
        }

        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function galeri()
    {
        $galeris = Galeri::all(); // Ambil semua galeri
        return view('galeri', compact('galeris'));
    }
}

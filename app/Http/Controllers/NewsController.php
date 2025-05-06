<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;


class NewsController extends Controller
{
    public function index()
    {
        $news = News::all(); // Ambil semua data berita dari database
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        // Simpan data berita
        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $imagePath,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dibuat!');
    }

    public function create()
    {
        return view('admin.news.create');
    }
    
    public function news()
    {
        $news = News::latest()->get(); // Ambil semua data berita dari DB
        return view('news', compact('news')); // Kirim data ke view
    }
}

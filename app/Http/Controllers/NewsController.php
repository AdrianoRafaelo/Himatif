<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // Ambil parameter 'type' dari query string
        $query = News::query();

        if ($type && in_array($type, ['news', 'announcement'])) {
            $query->where('type', $type);
        }

        $news = $query->orderBy('published_at', 'desc')->get();
        return view('admin.news.index', compact('news', 'type'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:news,announcement',
        ];

        if ($request->type === 'news') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validated = $request->validate($rules);

        $imagePath = null;
        if ($request->hasFile('image') && $request->type === 'news') {
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        News::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'published_at' => now(),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')->with('success', ($validated['type'] === 'news' ? 'Berita' : 'Pengumuman') . ' berhasil dibuat!');
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function news()
    {
        $news = News::where('type', 'news')->orderBy('published_at', 'desc')->get();
        $announcements = News::where('type', 'announcement')->orderBy('published_at', 'desc')->get();
        return view('news', compact('news', 'announcements'));
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita atau pengumuman berhasil dihapus.');
    }
}
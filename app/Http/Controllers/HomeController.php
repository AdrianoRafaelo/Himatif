<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\News;


class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil semua berita dan pengumuman, urutkan terbaru
        $news = News::orderBy('published_at', 'desc')->get();
        $events = Event::latest()->take(3)->get(); 
        return view('home', compact('news','events'));
    }
}
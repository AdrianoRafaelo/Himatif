<?php

namespace App\Http\Controllers;

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
        $news = News::latest()->take(6)->get(); // ambil 6 berita terbaru, atau sesuaikan
    return view('home', compact('news'));
    }
} 
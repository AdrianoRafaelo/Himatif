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
        $news = News::latest()->take(3)->get(); 
    return view('home', compact('news'));
    }
} 
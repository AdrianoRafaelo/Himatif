<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Event;


class StudentController extends Controller
{
    /**
     * Menampilkan dashboard mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data user dari session
        $user = session('user');

        // Cek apakah session ada dan role adalah mahasiswa
        if (!$user || !isset($user['role']) || $user['role'] !== 'mahasiswa') {
            return redirect('/')->with('error', 'Akses ditolak. Anda bukan mahasiswa atau belum login.');
        }

        // Ambil data berita terbaru
    $news = News::latest()->take(3)->get();
    $events = Event::latest()->take(3)->get(); 

    return view('student', compact('user', 'news', 'events'));
    }
}

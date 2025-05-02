<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class studentController extends Controller
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

        // Periksa apakah user yang login adalah mahasiswa
        if ($user['role'] !== 'mahasiswa') {
            return redirect('/')->with('error', 'Akses ditolak. Anda bukan mahasiswa.');
        }

        // Menampilkan halaman dashboard mahasiswa
        return view('student', compact('user'));
    }
}

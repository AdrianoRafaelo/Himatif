<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;

class AdminMahasiswaController extends Controller
{
    public function index()
    {
        $token = session('token');
    
        if (!$token) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }
    
        $response = Http::withToken($token)->get('https://cis.del.ac.id/api/library-api/mahasiswa?status=Aktif');
        dd($response->json());
            
        if ($response->successful()) {
            $mahasiswaList = $response->json();
            $mahasiswa = $mahasiswaList['data']['mahasiswa'] ?? [];
    
            return view('admin.kas', compact('mahasiswa'));
        } else {
            return view('admin.kas')->withErrors(['error' => 'Gagal mengambil data mahasiswa']);
        }
    }



public function store(Request $request)
{
    $mahasiswaBayar = $request->input('bayar', []); 

    foreach ($mahasiswaBayar as $nim => $data) {
        Payment::updateOrCreate(
            ['nim' => $nim, 'tanggal_bayar' => now()->toDateString()],
            [
                'nama' => $data['nama'],
                'angkatan' => $data['angkatan'],
                'prodi' => $data['prodi'],
            ]
        );
    }

    return back()->with('success', 'Data pembayaran berhasil disimpan.');
}

}

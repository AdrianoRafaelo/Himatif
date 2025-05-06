<?php

namespace App\Http\Controllers;

use App\Models\Bph;
use App\Models\Proker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    public function organization(Request $request)
    {
        // Ambil periode dari query string, default ke periode aktif
        $period = $request->query('period', '2025-2026');

        // Log untuk debugging
        Log::info('PublicController::organization dipanggil', [
            'period' => $period,
        ]);

        // Definisikan hierarki jabatan
        $positionOrder = [
            'Ketua' => 1,
            'Wakil Ketua' => 2,
            'Sekretaris 1' => 3,
            'Sekretaris 2' => 4,
            'Bendahara 1' => 5,
            'Bendahara 2' => 6,
        ];

        // Ambil anggota BPH untuk periode yang dipilih
        $bphs = Bph::with('user')
                   ->where('period', $period)
                   ->get()
                   ->sortBy(function ($bph) use ($positionOrder) {
                       return $positionOrder[$bph->position] ?? 999; // Jabatan yang tidak ada di hierarki akan diurutkan terakhir
                   });

        // Log jumlah anggota BPH dan urutan
        Log::info('Jumlah anggota BPH ditemukan', [
            'count' => $bphs->count(),
            'period' => $period,
            'positions' => $bphs->pluck('position')->toArray(),
        ]);

        // Ambil proker untuk periode yang dipilih
        $prokers = Proker::with('creator')
                        ->where('period', $period)
                        ->latest()
                        ->paginate(10);

        // Log jumlah proker
        Log::info('Jumlah proker ditemukan', [
            'count' => $prokers->count(),
            'period' => $period,
            'prokers' => $prokers->toArray()['data'],
        ]);

        // Ambil semua periode yang tersedia dari tabel BPH
        $periods = Bph::select('period')
                     ->distinct()
                     ->pluck('period')
                     ->sort()
                     ->values();

        // Log periode yang tersedia
        Log::info('Periode tersedia dari BPH', [
            'periods' => $periods->toArray(),
        ]);

        return view('organization', compact('bphs', 'prokers', 'period', 'periods'));
    }
}
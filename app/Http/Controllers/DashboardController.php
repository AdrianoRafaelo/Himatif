<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\Proposal;
use App\Models\Proker;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $events = Event::with('proker')->latest()->take(5)->get();
        $approvedProposals = Proposal::with('proker')->where('status', 'approved')->latest()->take(5)->get();
        $news = News::latest()->take(5)->get();
        $prokers = Proker::latest()->get();

        $periode = (int) request('periode', 3); // default 3 bulan terakhir

        // Ambil bulan dan tahun sekarang
        $now = Carbon::now();
        $labels = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        // Loop mundur sesuai periode
        for ($i = $periode - 1; $i >= 0; $i--) {
            $bulan = $now->copy()->subMonths($i)->month;
            $tahun = $now->copy()->subMonths($i)->year;
            $labels[] = $now->copy()->subMonths($i)->translatedFormat('F Y');

            $data = FinancialRecord::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->select(
                    DB::raw("SUM(CASE WHEN jenis = 'Pemasukan' THEN jumlah ELSE 0 END) as pemasukan"),
                    DB::raw("SUM(CASE WHEN jenis = 'Pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran")
                )
                ->first();

            $pemasukanData[] = $data->pemasukan ?? 0;
            $pengeluaranData[] = $data->pengeluaran ?? 0;
        }

        return view('admin.dashboard', [
            'bulanLabels' => $labels,
            'pemasukanData' => $pemasukanData,
            'pengeluaranData' => $pengeluaranData,
            'events' => $events,
            'approvedProposals' => $approvedProposals,
            'news' => $news,
            'prokers' => $prokers,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Exports\FinancialRecordsExport;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter bulan dan tahun dari query string
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');

        // Query dasar untuk mengambil data
        $query = FinancialRecord::with('details')->orderBy('tanggal', 'desc');

        // Filter berdasarkan bulan dan tahun jika ada
        if ($bulan && $tahun) {
            $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        } elseif ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        $records = $query->get();

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $records->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = $records->where('jenis', 'Pengeluaran')->sum('jumlah');

        return view('admin.keuangan.index', compact('records', 'totalPemasukan', 'totalPengeluaran', 'bulan', 'tahun'));
    }

    public function userIndex(Request $request)
    {
        // Ambil parameter bulan, tahun, dan periode dari query string
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        $periode = (int) $request->query('periode', 6); // default 6 bulan terakhir

        // Query dasar untuk mengambil data
        $query = FinancialRecord::with('details')->orderBy('tanggal', 'desc');

        // Filter berdasarkan bulan dan tahun jika ada
        if ($bulan && $tahun) {
            $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        } elseif ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        $records = $query->get();

        // Hitung total pemasukan, pengeluaran, dan saldo akhir
        $totalPemasukan = $records->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = $records->where('jenis', 'Pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Ambil data grafik sesuai periode (3, 6, atau 12 bulan terakhir)
        $now = now();
        $bulanLabels = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        for ($i = $periode - 1; $i >= 0; $i--) {
            $bulanLoop = $now->copy()->subMonths($i)->month;
            $tahunLoop = $now->copy()->subMonths($i)->year;
            $bulanLabels[] = $now->copy()->subMonths($i)->translatedFormat('F Y');

            $data = FinancialRecord::whereYear('tanggal', $tahunLoop)
                ->whereMonth('tanggal', $bulanLoop)
                ->selectRaw("SUM(CASE WHEN jenis = 'Pemasukan' THEN jumlah ELSE 0 END) as pemasukan,
                             SUM(CASE WHEN jenis = 'Pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran")
                ->first();

            $pemasukanData[] = $data->pemasukan ?? 0;
            $pengeluaranData[] = $data->pengeluaran ?? 0;
        }

        return view('keuangan', compact(
            'records',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'bulan',
            'tahun',
            'bulanLabels',
            'pemasukanData',
            'pengeluaranData'
        ));
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric',
            'detail_keterangan.*' => 'nullable|string',
            'detail_jumlah.*' => 'nullable|numeric'
        ]);

        $financial = FinancialRecord::create($request->only(['tanggal', 'keterangan', 'jenis', 'jumlah']));

        if ($request->detail_keterangan) {
            foreach ($request->detail_keterangan as $index => $keterangan) {
                if (!empty($keterangan) && isset($request->detail_jumlah[$index])) {
                    Detail::create([
                        'financial_id' => $financial->id,
                        'keterangan' => $keterangan,
                        'jumlah' => $request->detail_jumlah[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.keuangan.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $record = FinancialRecord::with('details')->findOrFail($id);
        return view('admin.keuangan.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric',
            'detail_keterangan.*' => 'nullable|string',
            'detail_jumlah.*' => 'nullable|numeric'
        ]);

        $record = FinancialRecord::findOrFail($id);
        $record->update($request->only(['tanggal', 'keterangan', 'jenis', 'jumlah']));
        $record->details()->delete();

        if ($request->detail_keterangan) {
            foreach ($request->detail_keterangan as $index => $keterangan) {
                if (!empty($keterangan) && isset($request->detail_jumlah[$index])) {
                    Detail::create([
                        'financial_id' => $record->id,
                        'keterangan' => $keterangan,
                        'jumlah' => $request->detail_jumlah[$index]
                    ]);
                }
            }
        }

        return redirect()->route('admin.keuangan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $record = FinancialRecord::findOrFail($id);
        $record->details()->delete();
        $record->delete();
        return redirect()->route('admin.keuangan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function downloadExcel(Request $request)
    {
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');
        return Excel::download(new FinancialRecordsExport($bulan, $tahun), 'keuangan_himatif.xlsx');
    }
}
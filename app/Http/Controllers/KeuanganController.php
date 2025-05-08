<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class KeuanganController extends Controller
{
    
        // Fungsi bantu untuk memeriksa role
        private function checkBendaharaRole()
        {
            $user = Session::get('user'); // Ubah kunci dari 'LocalUser' ke 'user'
            if (!$user || !isset($user['role']) || $user['role'] !== 'bendahara') {
                abort(403, 'Anda tidak memiliki akses ke halaman ini. Hanya bendahara yang diperbolehkan.');
            }
        }
    
        public function index()
        {
            $this->checkBendaharaRole(); // Panggil fungsi tanpa redirect
    
            $records = FinancialRecord::with('details')->orderBy('tanggal', 'desc')->get();
            return view('admin.keuangan.index', compact('records'));
        }
    
        public function userIndex()
        {
            $records = FinancialRecord::with('details')->orderBy('tanggal', 'desc')->get();
            $totalPemasukan = FinancialRecord::where('jenis', 'Pemasukan')->sum('jumlah');
            $totalPengeluaran = FinancialRecord::where('jenis', 'Pengeluaran')->sum('jumlah');
            $saldoAkhir = $totalPemasukan - $totalPengeluaran;
    
            return view('keuangan', compact('records', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'));
        }
    
        public function create()
        {
            $this->checkBendaharaRole();
    
            return view('admin.keuangan.create');
        }
    
        public function store(Request $request)
        {
            $this->checkBendaharaRole();
    
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
            $this->checkBendaharaRole();
    
            $record = FinancialRecord::with('details')->findOrFail($id);
            return view('admin.keuangan.edit', compact('record'));
        }
    
        public function update(Request $request, $id)
        {
            $this->checkBendaharaRole();
    
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
            $this->checkBendaharaRole();
    
            $record = FinancialRecord::findOrFail($id);
            $record->details()->delete();
            $record->delete();
    
            return redirect()->route('admin.keuangan.index')->with('success', 'Data berhasil dihapus.');
        }
    
}
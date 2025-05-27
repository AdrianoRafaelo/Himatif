<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;

class KeuanganApiController extends Controller
{
    public function index()
    {
        $records = FinancialRecord::with('details')->orderBy('tanggal', 'desc')->get();
        return response()->json($records);
    }

    public function show($id)
    {
        $record = FinancialRecord::with('details')->find($id);
        if (!$record) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
        return response()->json($record);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric',
            'detail_keterangan.*' => 'nullable|string',
            'detail_jumlah.*' => 'nullable|numeric',
        ]);

        $record = FinancialRecord::create($request->only(['tanggal', 'keterangan', 'jenis', 'jumlah']));

        if ($request->detail_keterangan) {
            foreach ($request->detail_keterangan as $i => $keterangan) {
                if (!empty($keterangan) && isset($request->detail_jumlah[$i])) {
                    Detail::create([
                        'financial_id' => $record->id,
                        'keterangan' => $keterangan,
                        'jumlah' => $request->detail_jumlah[$i],
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Data berhasil disimpan.', 'data' => $record], 201);
    }

    public function update(Request $request, $id)
    {
        $record = FinancialRecord::find($id);
        if (!$record) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric',
            'detail_keterangan.*' => 'nullable|string',
            'detail_jumlah.*' => 'nullable|numeric',
        ]);

        $record->update($request->only(['tanggal', 'keterangan', 'jenis', 'jumlah']));
        $record->details()->delete();

        if ($request->detail_keterangan) {
            foreach ($request->detail_keterangan as $i => $keterangan) {
                if (!empty($keterangan) && isset($request->detail_jumlah[$i])) {
                    Detail::create([
                        'financial_id' => $record->id,
                        'keterangan' => $keterangan,
                        'jumlah' => $request->detail_jumlah[$i],
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Data berhasil diperbarui.', 'data' => $record]);
    }

    public function destroy($id)
    {
        $record = FinancialRecord::find($id);
        if (!$record) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $record->details()->delete();
        $record->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

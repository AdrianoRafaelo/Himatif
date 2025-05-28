<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\Bph;
use App\Models\LocalUser;
use App\Notifications\ReportUploadedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\FinancialRecord;

class ProkerController extends Controller
{
    public function index()
    {
        $prokers = Proker::with('creator')->latest()->paginate(10);
        return view('admin.proker.index', compact('prokers'));
    }

    public function create()
    {
        $periods = Bph::select('period')->distinct()->pluck('period')->sort()->values();
        return view('admin.proker.create', compact('periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'location' => 'nullable|string',
            'planned_date' => 'nullable|string',
            'actual_date' => 'nullable|date',
            'funding_source' => 'nullable|string',
            'planned_budget' => 'nullable|numeric',
            'actual_budget' => 'nullable|numeric',
            'status' => 'nullable|string|in:Perencanaan,Persiapan,Pelaksanaan,Selesai',
            'period' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'report_file' => 'nullable|file|mimes:pdf|max:5120', // Maks 5MB
        ]);

        $periodExists = Bph::where('period', $request->period)->exists();
        if (!$periodExists) {
            return redirect()->back()->with('error', 'Periode tidak valid. Pilih periode yang sudah memiliki anggota BPH.');
        }

        $plannedDate = $request->planned_date ? $request->planned_date . '-01' : null;

        if ($plannedDate && $request->actual_date && $request->actual_date < $plannedDate) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['actual_date' => 'Tanggal realisasi tidak boleh lebih awal dari tanggal rencana.']);
        }

        $proker = new Proker([
            'subject' => $request->subject,
            'description' => $request->description,
            'objective' => $request->objective,
            'location' => $request->location,
            'planned_date' => $plannedDate,
            'actual_date' => $request->actual_date,
            'funding_source' => $request->funding_source,
            'planned_budget' => $request->planned_budget,
            'actual_budget' => $request->actual_budget,
            'status' => $request->status ?? 'Perencanaan',
            'period' => $request->period,
            'created_by' => Auth::id(),
        ]);

        if ($request->hasFile('report_file')) {
            $proker->report_file = $request->file('report_file')->store('reports', 'public');
            $proker->approval_status = 'pending';
        }

        $proker->save();

        // Kirim notifikasi ke kaprodi jika ada berita acara
        if ($proker->report_file) {
            $kaprodi = LocalUser::where('role', 'kaprodi')->first();
            if ($kaprodi) {
                $kaprodi->notify(new ReportUploadedNotification($proker));
            }
        }

        return redirect()->route('proker.index')->with('success', 'Proker berhasil dibuat.');
    }

    public function edit($id)
    {
        $proker = Proker::findOrFail($id);
        $periods = Bph::select('period')->distinct()->pluck('period')->sort()->values();
        return view('admin.proker.edit', compact('proker', 'periods'));
    }

    public function update(Request $request, $id)
    {
        $proker = Proker::findOrFail($id);

        $rules = [
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'location' => 'nullable|string',
            'planned_date' => 'nullable|date',
            'funding_source' => 'nullable|string',
            'planned_budget' => 'nullable|numeric',
            'period' => 'required|string',
            'status' => 'required|string',
        ];

        // Jika ada upload berita acara, wajib isi realisasi anggaran & tanggal
        if ($request->hasFile('report_file') || $proker->report_file || $request->status == 'Selesai') {
            $rules['actual_budget'] = 'required|numeric|min:1';
            $rules['actual_date'] = 'required|date';
        }

        $request->validate($rules);

        $periodExists = Bph::where('period', $request->period)->exists();
        if (!$periodExists) {
            return redirect()->back()->with('error', 'Periode tidak valid. Pilih periode yang sudah memiliki anggota BPH.');
        }

        $plannedDate = $request->planned_date ? $request->planned_date . '-01' : null;

        // Cegah admin mengubah status menjadi "Selesai"
        if (
            isset($request->status) &&
            $request->status === 'Selesai' &&
            (!session('user') || session('user')['role'] !== 'kaprodi')
        ) {
            return redirect()->back()->with('error', 'Status "Selesai" hanya dapat diubah oleh kaprodi melalui proses approve berita acara.');
        }

        $data = [
            'subject' => $request->subject,
            'description' => $request->description,
            'objective' => $request->objective,
            'location' => $request->location,
            'planned_date' => $plannedDate,
            'actual_date' => $request->actual_date,
            'funding_source' => $request->funding_source,
            'planned_budget' => $request->planned_budget,
            'actual_budget' => $request->actual_budget,
            'status' => $request->status,
            'period' => $request->period,
        ];

        if ($request->hasFile('report_file')) {
            // Hapus file lama jika ada
            if ($proker->report_file) {
                Storage::disk('public')->delete($proker->report_file);
            }
            $data['report_file'] = $request->file('report_file')->store('reports', 'public');
            $data['approval_status'] = 'pending';
        }

        $proker->update($data);

        // Jika sumber dana HIMATIF dan realisasi anggaran diisi, masukkan keuangan sebagai pengeluaran
        if (
            strtolower($request->funding_source) === 'himatif' &&
            $request->actual_budget &&
            $request->actual_date
        ) {
            // Cek apakah sudah pernah dicatat agar tidak double
            $exists = FinancialRecord::where('keterangan', 'LIKE', '%Realisasi Proker: ' . $proker->subject . '%')
                ->where('tanggal', $request->actual_date)
                ->where('jenis', 'Pengeluaran')
                ->first();

            if (!$exists) {
                FinancialRecord::create([
                    'tanggal'     => $request->actual_date,
                    'keterangan'  => 'Realisasi Proker: ' . $proker->subject,
                    'jenis'       => 'Pengeluaran',
                    'jumlah'      => $request->actual_budget,
                ]);
            }
        }

        return redirect()->route('proker.index')->with('success', 'Proker berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $proker = Proker::findOrFail($id);
        if ($proker->report_file) {
            Storage::disk('public')->delete($proker->report_file);
        }
        $proker->delete();
        return redirect()->route('proker.index')->with('success', 'Proker berhasil dihapus.');
    }

    // Method untuk kaprodi meninjau berita acara
public function reports()
{
    if (session('user')['role'] !== 'kaprodi') {
        abort(403, 'Akses ditolak. Hanya kaprodi yang boleh mengakses halaman ini.');
    }
    $prokers = Proker::whereNotNull('report_file')
        ->with('creator', 'approver')
        ->latest()
        ->paginate(10);
    return view('kaprodi.reports.index', compact('prokers'));
}
public function approve(Request $request, $id)
{
    if (session('user')['role'] !== 'kaprodi') {
        abort(403, 'Akses ditolak. Hanya kaprodi yang boleh menyetujui berita acara.');
    }
    $proker = Proker::findOrFail($id);
    $proker->update([
        'approval_status' => 'approved',
        'status' => 'Selesai',
    ]);

    // Update semua event yang terkait proker ini menjadi selesai
    \App\Models\Event::where('proker_id', $proker->id)
        ->where('status', '!=', 'completed') // Hanya update yang belum selesai
        ->update(['status' => 'completed']);

    return redirect()->route('admin.kaprodi.proker.reports')->with('success', 'Berita acara disetujui, status proker dan event terkait diperbarui.');
}

public function reject(Request $request, $id)
{
    if (session('user')['role'] !== 'kaprodi') {
        abort(403, 'Akses ditolak. Hanya kaprodi yang boleh menolak berita acara.');
    }
    $proker = Proker::findOrFail($id);
    $proker->update([   
        'approval_status' => 'rejected',
    ]);

    return redirect()->route('admin.kaprodi.proker.reports')->with('success', 'Berita acara ditolak.');
}
}
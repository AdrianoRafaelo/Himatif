@extends('admin.layouts')

@section('title', 'Keuangan')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Data Keuangan</h4>

    <form action="{{ route('admin.keuangan.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $record->tanggal }}" max="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $record->keterangan }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="Pemasukan" {{ $record->jenis == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="Pengeluaran" {{ $record->jenis == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $record->jumlah }}" required>
        </div>

        <!-- Bagian Edit Detail -->
        <h5 class="mt-4">Detail Transaksi</h5>
        <div id="detail-container">
            @foreach($record->details as $detail)
                <div class="detail-item mb-2">
                    <input type="hidden" name="detail_ids[]" value="{{ $detail->id }}">
                    <input type="text" name="detail_keterangan[]" class="form-control mb-1" value="{{ $detail->keterangan }}" placeholder="Keterangan Detail">
                    <input type="number" name="detail_jumlah[]" class="form-control mb-1" value="{{ $detail->jumlah }}" placeholder="Jumlah">
                    <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
                </div>
            @endforeach
        </div>

        <!-- Tambah Detail Baru -->
        <button type="button" id="add-detail" class="btn btn-success btn-sm mt-2">+ Tambah Detail</button>

        <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
        <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary mt-4">Batal</a>
    </form>
</div>

<!-- Script untuk tambah/hapus detail -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Membatasi tanggal maksimal ke hari ini
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tanggal"]').setAttribute('max', today);

    document.getElementById("add-detail").addEventListener("click", function() {
        let container = document.getElementById("detail-container");
        let div = document.createElement("div");
        div.classList.add("detail-item", "mb-2");
        div.innerHTML = `
            <input type="hidden" name="detail_ids[]" value="">
            <input type="text" name="detail_keterangan[]" class="form-control mb-1" placeholder="Keterangan Detail">
            <input type="number" name="detail_jumlah[]" class="form-control mb-1" placeholder="Jumlah">
            <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
        `;
        container.appendChild(div);
    });

    document.getElementById("detail-container").addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-detail")) {
            event.target.parentElement.remove();
        }
    });
});
</script>
@endsection

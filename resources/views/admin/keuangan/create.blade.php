@extends('admin.layouts')

@section('title', 'Keuangan')

@section('content')
<div class="container">
    <h4 class="mb-4 text-primary font-weight-bold">Tambah Data Keuangan</h4>
    <div class="card p-4 shadow-sm">
        <form action="{{ route('admin.keuangan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jenis</label>
                <select name="jenis" class="form-control" required>
                    <option value="Pemasukan">Pemasukan</option>
                    <option value="Pengeluaran">Pengeluaran</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>

            <h5 class="mt-4">Detail Pengeluaran (Opsional)</h5>
            <div id="detail-container">
                <div class="form-group d-flex">
                    <input type="text" name="detail_keterangan[]" class="form-control mr-2" placeholder="Keterangan Detail">
                    <input type="number" name="detail_jumlah[]" class="form-control mr-2" placeholder="Jumlah">
                    <button type="button" class="btn btn-danger remove-detail">X</button>
                </div>
            </div>
            <button type="button" id="add-detail" class="btn btn-secondary mt-2">+ Tambah Detail</button>

            <button type="submit" class="btn btn-success mt-3">Simpan</button>
        </form>
    </div>
</div>

<script>
        // Membatasi tanggal maksimal ke hari ini
    document.addEventListener("DOMContentLoaded", function () {
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="tanggal"]').setAttribute('max', today);
    });

    document.getElementById('add-detail').addEventListener('click', function () {
        let container = document.getElementById('detail-container');
        let div = document.createElement('div');
        div.classList.add('form-group', 'd-flex');
        div.innerHTML = `
            <input type="text" name="detail_keterangan[]" class="form-control mr-2" placeholder="Keterangan Detail">
            <input type="number" name="detail_jumlah[]" class="form-control mr-2" placeholder="Jumlah">
            <button type="button" class="btn btn-danger remove-detail">X</button>
        `;
        container.appendChild(div);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-detail')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection

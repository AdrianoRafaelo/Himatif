@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Daftar Proker</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('proker.create') }}" class="btn btn-primary">Buat Proker Baru</a>

    <table class="table mt-3">
    <thead>
        <tr>
            <th>Perihal</th>
            <th>Tujuan</th>
            <th>Lokasi</th>
            <th>Rencana Tanggal</th>
            <th>Realisasi Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prokers as $proker)
        <tr>
            <td>{{ $proker->subject }}</td>
            <td>{{ $proker->objective }}</td>
            <td>{{ $proker->location }}</td>
            <td>{{ $proker->planned_date }}</td>
            <td>{{ $proker->actual_date }}</td>
            <td>{{ $proker->status }}</td>
            <td>
                <a href="{{ route('proker.edit', $proker->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('proker.destroy', $proker->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection

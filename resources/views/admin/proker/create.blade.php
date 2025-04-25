@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
    <h1>Tambah Program Kerja</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proker.store') }}" method="POST">
        @csrf
        <label>Judul:</label><br>
        <input type="text" name="judul" value="{{ old('judul') }}" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi">{{ old('deskripsi') }}</textarea><br><br>

        <label>Tanggal Mulai:</label><br>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"><br><br>

        <label>Tanggal Selesai:</label><br>
        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"><br><br>

        <button type="submit">Simpan</button>
        <a href="{{ route('proker.index') }}">Batal</a>
    </form>
@endsection

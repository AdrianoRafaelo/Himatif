@extends('admin.layouts')

@section('title', 'Galeri')

@section('content')

<div class="container">
    <h1>Edit Galeri</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $galeri->judul }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $galeri->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Saat Ini</label><br>
            @if($galeri->gambar)
                <img src="{{ asset('uploads/galeri/' . $galeri->gambar) }}" width="100">
            @else
                Tidak ada gambar
            @endif
        </div>
        <div class="mb-3">
            <label>Ganti Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
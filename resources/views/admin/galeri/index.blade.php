@extends('admin.layouts')

@section('title', 'Galeri')

@section('content')

<div class="container">
    <h1>Daftar Galeri</h1>
    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary mb-3">Tambah Galeri</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($galeris as $galeri)
            <tr>
                <td>{{ $galeri->judul }}</td>
                <td>{{ $galeri->deskripsi }}</td>
                <td>
                    @if($galeri->gambar)
                        <img src="{{ asset('uploads/galeri/' . $galeri->gambar) }}" width="100">
                    @else
                        Tidak ada gambar
                    @endif
                </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Program Kerja</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Program Kerja</h6>
            <a href="{{ route('proker.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Program Kerja
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $proker)
                        <tr>
                            <td>{{ $proker->judul }}</td>
                            <td>{{ $proker->deskripsi }}</td>
                            <td>{{ $proker->tanggal_mulai }} - {{ $proker->tanggal_selesai }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('proker.edit', $proker->id) }}" class="btn btn-warning btn-sm mr-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('proker.destroy', $proker->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada program kerja</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

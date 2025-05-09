@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Base Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        font-size: 24px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
    }

    /* Alert Styles */
    .alert {
        padding: 10px 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Button Styles */
    .btn {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #3490dc;
        color: white;
        border: 1px solid #3490dc;
    }

    .btn-primary:hover {
        background-color: #2779bd;
        border-color: #2779bd;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }

    .btn-warning {
        background-color: #ffed4a;
        color: #8e6c03;
        border: 1px solid #ffed4a;
    }

    .btn-warning:hover {
        background-color: #e6c729;
        border-color: #e6c729;
    }

    .btn-danger {
        background-color: #e3342f;
        color: white;
        border: 1px solid #e3342f;
    }

    .btn-danger:hover {
        background-color: #cc1f1a;
        border-color: #cc1f1a;
    }

    /* Table Styles */
    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #e2e8f0;
    }

    .table th {
        background-color: #f7fafc;
        font-weight: 600;
        color: #4a5568;
        text-transform: uppercase;
        font-size: 12px;
    }

    .table tr:nth-child(even) {
        background-color: #f8fafc;
    }

    .table tr:hover {
        background-color: #f0f7ff;
    }

    /* Image Styles */
    img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }

    /* Text Center */
    .text-center {
        text-align: center;
    }

    /* Margin Utilities */
    .mb-3 {
        margin-bottom: 15px;
    }

    .mb-4 {
        margin-bottom: 20px;
    }

    /* Form Inline Styles */
    form[style*="display:inline"] {
        display: inline-block;
        margin-left: 5px;
    }
</style>
<div class="container">
    <h1 class="mb-4">Daftar Berita</h1>
    
    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Tambah Berita</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Konten</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($news as $index => $news)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="Gambar" width="100">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $news->title }}</td>
                    <td>{{ Str::limit(strip_tags($news->content), 100) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('news.edit', $news->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada berita.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

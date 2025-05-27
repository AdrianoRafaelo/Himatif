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

    /* Type Badge Styles */
    .type-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .type-news {
        background-color: #007bff;
        color: white;
    }

    .type-announcement {
        background-color: #28a745;
        color: white;
    }

    /* Filter Styles */
    .filter-form {
        display: inline-block;
        margin-left: 10px;
    }

    .filter-select {
        padding: 6px 10px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
    }
</style>
<div class="container">
    <h1 class="mb-4">Daftar Berita & Pengumuman</h1>
    
    <div class="mb-3">
        <a href="{{ route('news.create') }}" class="btn btn-primary">Tambah Berita atau Pengumuman</a>
        
        <form class="filter-form" action="{{ route('admin.news.index') }}" method="GET">
            <select class="filter-select" name="type" onchange="this.form.submit()">
                <option value="" {{ !$type ? 'selected' : '' }}>Semua</option>
                <option value="news" {{ $type == 'news' ? 'selected' : '' }}>Berita</option>
                <option value="announcement" {{ $type == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
            </select>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tipe</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Konten</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($news as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="type-badge {{ $item->type === 'news' ? 'type-news' : 'type-announcement' }}">
                            {{ $item->type === 'news' ? 'Berita' : 'Pengumuman' }}
                        </span>
                    </td>
                    <td>
                        @if ($item->type === 'news' && $item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar" width="100">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $item->title }}</td>
                    <td>{{ Str::limit(strip_tags($item->content), 100) }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('news.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
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
                    <td colspan="6" class="text-center">Belum ada {{ $type == 'news' ? 'berita' : ($type == 'announcement' ? 'pengumuman' : 'berita atau pengumuman') }}.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
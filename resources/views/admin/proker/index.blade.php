@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        color: #2c3e50;
        font-size: 28px;
        margin-bottom: 25px;
        font-weight: 600;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: #3498db;
        color: white;
        border: 1px solid #2980b9;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-warning {
        background-color: #f39c12;
        color: white;
        border: 1px solid #e67e22;
    }

    .btn-warning:hover {
        background-color: #e67e22;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: white;
        border: 1px solid #c0392b;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 13px;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
    }

    .table th {
        background-color: #f8f9fa;
        color: #495057;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table tr:hover {
        background-color: #f8f9fa;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    .mt-3 {
        margin-top: 1rem !important;
    }

    form {
        display: inline;
        margin-left: 5px;
    }

    @media (max-width: 768px) {
        .table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
<div class="container">
    <h1>Daftar Proker</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
    $userRole = session('user')['role'];
    @endphp

    @if($userRole === 'admin')
        <a href="{{ route('proker.create') }}" class="btn btn-primary mb-3">Buat Proker Baru</a>
    @else
        <button class="btn btn-primary mb-3 disabled" onclick="showAccessDeniedAlert()">Buat Proker Baru</button>
    @endif

    <script>
        function showAccessDeniedAlert() {
            alert('Tidak dapat di akses, (hanya admin)');
        }
    </script>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Perihal</th>
                <th>Tujuan</th>
                <th>Lokasi</th>
                <th>Rencana Tanggal</th>
                <th>Realisasi Tanggal</th>
                <th>Status</th>
                <th>Status Persetujuan</th>
                <th>Periode</th>
                @if(session('user')['role'] === 'admin')
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($prokers as $proker)
                <tr>
                    <td>{{ $proker->subject }}</td>
                    <td>{{ $proker->objective }}</td>
                    <td>{{ $proker->location }}</td>
                    <td>{{ $proker->planned_date ? \Carbon\Carbon::parse($proker->planned_date)->format('Y-m') : '-' }}</td>
                    <td>{{ $proker->actual_date ? \Carbon\Carbon::parse($proker->actual_date)->format('Y-m-d') : '-' }}</td>
                    <td>{{ $proker->status }}</td>
                    <td>{{ $proker->approval_status ? ucfirst($proker->approval_status) : 'Belum ada' }}</td>
                    <td>{{ $proker->period }}</td>
                    <td>
                        @if(session('user')['role'] === 'admin')
                            <div class="d-flex gap-1">
                                <a href="{{ route('proker.edit', $proker->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('proker.destroy', $proker->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
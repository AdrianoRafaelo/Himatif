@extends('admin.layouts')

@section('title', 'Tinjau Berita Acara')

@section('content')
<div class="container">
    <h1>Tinjau Berita Acara</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            Daftar Berita Acara
        </div>
        <div class="card-body">
            @if($prokers->isEmpty())
                <p>Tidak ada berita acara yang perlu ditinjau saat ini.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>File Berita Acara</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prokers as $proker)
                            <tr>
                                <td>{{ $proker->subject }}</td>
                                <td>{{ $proker->location }}</td>
                                <td>
                                    <a href="{{ Storage::url($proker->report_file) }}" target="_blank">Lihat File</a>
                                </td>
                                <td>{{ ucfirst($proker->approval_status) }}</td>
                                <td>
                                    @if($proker->approval_status == 'pending')
                                        <form action="{{ route('admin.kaprodi.proker.approve', $proker->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui berita acara ini?')">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.kaprodi.proker.reject', $proker->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak berita acara ini?')">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Aksi ditutup</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $prokers->links() }}
            @endif
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Manajemen Event</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            <a href="{{ route('admin.event.create') }}" class="btn btn-primary mb-4">
                <i class="fas fa-plus-circle mr-2"></i>Tambah Event
            </a>

            @if ($scheduledEvents->isEmpty() && $completedEvents->isEmpty())
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <p>Tidak ada event yang tersedia saat ini.</p>
                    </div>
                </div>
            @else
                <!-- Scheduled Events -->
                @if ($scheduledEvents->isNotEmpty())
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Scheduled Events</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Proker</th>
                                            <th>Lokasi</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scheduledEvents as $event)
                                            <tr>
                                                <td>{{ $event->name }}</td>
                                                <td>{{ $event->proker->subject ?? '-' }}</td>
                                                <td>{{ $event->location }}</td>
                                                <td>{{ $event->start_date }}</td>
                                                <td>{{ $event->end_date }}</td>
                                                <td>{{ $event->status }}</td>
                                                <td>
                                                    <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                    <!-- Tautan ke halaman partisipan -->
                                                    <a href="{{ route('admin.event.participants', $event->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-users"></i> Show Participants
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Completed Events -->
                @if ($completedEvents->isNotEmpty())
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Completed Events</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Proker</th>
                                            <th>Lokasi</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($completedEvents as $event)
                                            <tr>
                                                <td>{{ $event->name }}</td>
                                                <td>{{ $event->proker->name ?? '-' }}</td>
                                                <td>{{ $event->location }}</td>
                                                <td>{{ $event->start_date }}</td>
                                                <td>{{ $event->end_date }}</td>
                                                <td>{{ $event->status }}</td>
                                                <td>
                                                    <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                    <!-- Tautan ke halaman partisipan -->
                                                    <a href="{{ route('admin.event.participants', $event->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-users"></i> Show Participants
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

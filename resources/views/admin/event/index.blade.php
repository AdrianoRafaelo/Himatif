@extends('admin.layouts')

@section('title', 'Event')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1>Daftar Event</h1>
        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Event</th>
                            <th>Proker</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->proker->subject }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                {{ $event->start_date->format('d M Y') }}<br>
                                s/d {{ $event->end_date->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge 
                                    @if($event->status == 'scheduled') bg-primary
                                    @elseif($event->status == 'completed') bg-success
                                    @elseif($event->status == 'cancelled') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.event.show', $event->id) }}" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.event.edit', $event->id) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.event.destroy', $event->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            title="Hapus" onclick="return confirm('Yakin menghapus event ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
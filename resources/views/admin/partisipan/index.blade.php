@extends('admin.layouts')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Daftar Partisipan Semua Event</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Partisipan</h6>
                    <div>
                        <a href="{{ route('admin.partisipan.export', request('event_id')) }}" class="btn btn-primary btn-sm ml-2">
                            <i class="fas fa-download mr-2"></i>Export CSV
                        </a>
                        <button type="button" id="check-all" class="btn btn-info btn-sm ml-2">Check All</button>
                        <button type="submit" form="attendance-form" class="btn btn-success btn-sm ml-2">Simpan Perubahan</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($registrations->isEmpty())
                            <p>Tidak ada partisipan untuk ditampilkan.</p>
                        @else
                            <form id="attendance-form" action="{{ route('admin.partisipan.updateAttendanceBulk') }}" method="POST">
                                @csrf
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>NIM</th>
                                            <th>Angkatan</th>
                                            <th>Prodi</th>
                                            <th>Event</th>
                                            <th>Status Kehadiran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registrations as $r)
                                            <tr>
                                                <td>{{ $r->student_name }}</td>
                                                <td>{{ $r->email ?? '-' }}</td>
                                                <td>{{ $r->nim }}</td>
                                                <td>{{ $r->angkatan }}</td>
                                                <td>{{ $r->prodi }}</td>
                                                <td>
                                                    <a href="{{ route('admin.partisipan.show', $r->event_id) }}">{{ $r->event->nama_event }}</a>
                                                </td>
                                                <td>{{ $r->hadir ? 'Hadir' : 'Tidak Hadir' }}</td>
                                                <td>
                                                    <input type="hidden" name="registration_ids[]" value="{{ $r->id }}">
                                                    <input type="checkbox" class="attendance-checkbox" name="attendance_status[{{ $r->id }}]" value="1" {{ $r->hadir ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('check-all').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.attendance-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = true; // Set semua checkbox menjadi checked
        });
    });
</script>
@endpush
@endsection

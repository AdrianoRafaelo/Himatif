@extends('admin.layouts')

@section('title', 'Daftar Partisipan')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Registrasi - {{ isset($event) && $event ? $event->name : 'Semua Event' }}</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (isset($participantsByEvent) && !empty($participantsByEvent))
        <!-- Data dikelompokkan berdasarkan event_id (dari index) -->
        @foreach ($participantsByEvent as $eventId => $participants)
            <h3 class="mt-4">
                Event: {{ isset($events[$eventId]) ? $events[$eventId]->name : 'Event Tidak Ditemukan (ID: ' . $eventId . ')' }}
            </h3>
            <a href="{{ route('registrations.export', $eventId) }}" class="btn btn-success mb-3">
                Unduh Data (CSV)
            </a>

            @if (empty($participants))
                <p>Tidak ada partisipan untuk event ini.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Mahasiswa</th>
                            <th>Username</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Program Studi</th>
                            <th>Status Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participants as $participant)
                            <tr>
                                <td>{{ $participant['id'] }}</td>
                                <td>{{ $participant['nama'] }}</td>
                                <td>{{ $participant['username'] }}</td>
                                <td>{{ $participant['nim'] }}</td>
                                <td>{{ $participant['angkatan'] }}</td>
                                <td>{{ $participant['prodi'] }}</td>
                                <td>{{ $participant['attendance_status'] }}</td>
                                <td>
                                    <form action="{{ route('registrations.updateAttendance', $participant['id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="attendance_status" class="form-select" onchange="this.form.submit()">
                                            <option value="Hadir" {{ $participant['attendance_status'] == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="Tidak Hadir" {{ $participant['attendance_status'] == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                            <option value="IZIN" {{ $participant['attendance_status'] == 'IZIN' ? 'selected' : '' }}>Izin</option>
                                            <option value="Belum Dikonfirmasi" {{ $participant['attendance_status'] == 'Belum Dikonfirmasi' ? 'selected' : '' }}>Belum Dikonfirmasi</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach

        <!-- Tombol untuk mengunduh semua data -->
        <a href="{{ route('registrations.export') }}" class="btn btn-success mt-3">
            Unduh Semua Data (CSV)
        </a>

    @elseif (isset($participants) && !empty($participants))
        <!-- Data tidak dikelompokkan (dari showParticipants) -->
        <a href="{{ route('registrations.export', isset($event) ? $event->id : null) }}" class="btn btn-success mb-3">
            Unduh Data (CSV)
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>NIM</th>
                    <th>Angkatan</th>
                    <th>Prodi</th>
                    <th>Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr>
                        <td>{{ $participant['id'] }}</td>
                        <td>{{ $participant['nama'] }}</td>
                        <td>{{ $participant['username'] }}</td>
                        <td>{{ $participant['nim'] }}</td>
                        <td>{{ $participant['angkatan'] }}</td>
                        <td>{{ $participant['prodi'] }}</td>
                        <td>{{ $participant['attendance_status'] }}</td>
                        <td>
                            <form action="{{ route('registrations.updateAttendance', $participant['id']) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="attendance_status" class="form-select" onchange="this.form.submit()">
                                    <option value="Hadir" {{ $participant['attendance_status'] == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Tidak Hadir" {{ $participant['attendance_status'] == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                    <option value="IZIN" {{ $participant['attendance_status'] == 'IZIN' ? 'selected' : '' }}>Izin</option>
                                    <option value="Belum Dikonfirmasi" {{ $participant['attendance_status'] == 'Belum Dikonfirmasi' ? 'selected' : '' }}>Belum Dikonfirmasi</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if (empty($participants))
                    <tr><td colspan="9" class="text-center">Tidak ada partisipan untuk event ini.</td></tr>
                @endif
            </tbody>
        </table>
    @else
        <p>Tidak ada data registrasi.</p>
    @endif
</div>
@endsection
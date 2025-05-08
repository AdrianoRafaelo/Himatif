@extends('layouts.main')

@section('title', 'Organisasi HIMATIF')

@section('content')

<style>
    .keuangan-container {
        padding-top: 120px;
        padding-bottom: 50px;
    }

    @media (max-width: 768px) {
        .keuangan-container {
            padding-top: 100px;
        }
    }

    .badge.bg-success {
        background-color: #28a745 !important;
    }

    .badge.bg-danger {
        background-color: #dc3545 !important;
    }

    .collapse ul {
        margin: 0;
        padding-left: 20px;
    }
</style>

<div class="container keuangan-container">
    <h2 class="text-center mb-5 fw-bold">Transparansi Keuangan</h2>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $record->keterangan }}</td>
                    <td class="text-center">
                        <span class="badge {{ strtolower($record->jenis) == 'pemasukan' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($record->jenis) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($record->jumlah, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#detail-{{ $record->id }}">
                            Lihat Detail
                        </button>
                    </td>
                </tr>
                <tr id="detail-{{ $record->id }}" class="collapse">
                    <td colspan="5">
                        @if ($record->details->count() > 0)
                            <ul>
                                @foreach($record->details as $detail)
                                <li>{{ $detail->keterangan }} - Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Tidak ada detail tambahan.</p>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data keuangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
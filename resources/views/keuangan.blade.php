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

    <!-- Filter Periode Grafik Keuangan -->
    <form method="GET" class="mb-4">
        <label for="periode" class="me-2 fw-bold">Periode Grafik:</label>
        <select name="periode" id="periode" onchange="this.form.submit()" class="form-select w-auto d-inline">
            <option value="3" {{ request('periode', '6') == '3' ? 'selected' : '' }}>3 Bulan Terakhir</option>
            <option value="6" {{ request('periode', '6') == '6' ? 'selected' : '' }}>6 Bulan Terakhir</option>
            <option value="12" {{ request('periode', '6') == '12' ? 'selected' : '' }}>12 Bulan (Setahun)</option>
        </select>
    </form>

    <!-- Grafik Keuangan Publik -->
    <div class="mb-5">
        <h5 class="fw-bold mb-3">Grafik Keuangan</h5>
        <canvas id="keuanganChart" height="80"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('keuanganChart').getContext('2d');
        const keuanganChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bulanLabels),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($pemasukanData),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($pengeluaranData),
                        backgroundColor: 'rgba(255, 99, 132, 0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>

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
    <!-- Saldo Akhir di bawah tabel -->
    <div class="mb-4 mt-3">
        <div class="alert alert-info text-center fw-bold">
            Saldo Akhir: Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
        </div>
    </div>
</div>

@php
    $totalPemasukan = $records->where('jenis', 'Pemasukan')->sum('jumlah');
    $totalPengeluaran = $records->where('jenis', 'Pengeluaran')->sum('jumlah');
@endphp

@endsection
@extends('admin.layouts')

@section('title', 'Keuangan')

@section('content')
<div class="container">
    <h4 class="mb-4">Transparansi Keuangan</h4>

    <!-- Form Filter Bulan dan Tahun -->
    <form method="GET" action="{{ route('admin.keuangan.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="bulan" class="form-control">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <select name="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y') - 2; $i <= date('Y') + 0; $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    {{-- Tombol tambah data hanya untuk bendahara --}}
    @if(session('user')['role'] === 'bendahara')
        <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary mb-4">+ Tambah Data</a>
    @endif

    <a href="{{ route('admin.keuangan.download', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" class="btn btn-success mb-4">
        <i class="fa fa-file-excel"></i> Download Excel
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <canvas id="keuanganLineChart" height="80"></canvas>
    </div>

    <div class="row">
        <!-- Tabel Pemasukan -->
        <div class="col-md-6">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Rincian Pemasukan</h5>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPemasukan = 0; @endphp
                        @foreach($records->where('jenis', 'Pemasukan') as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $record->keterangan }}</td>
                                <td>Rp {{ number_format($record->jumlah, 0, ',', '.') }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('admin.keuangan.edit', $record->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.keuangan.destroy', $record->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php $totalPemasukan += $record->jumlah; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total Pemasukan</th>
                            <th>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tabel Pengeluaran -->
        <div class="col-md-6">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Rincian Pengeluaran</h5>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPengeluaran = 0; @endphp
                        @foreach($records->where('jenis', 'Pengeluaran') as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $record->keterangan }}</td>
                                <td>Rp {{ number_format($record->jumlah, 0, ',', '.') }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-info btn-sm me-1" data-toggle="modal" data-target="#detailModal{{ $record->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.keuangan.edit', $record->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.keuangan.destroy', $record->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Detail Pengeluaran -->
                            <div class="modal fade" id="detailModal{{ $record->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pengeluaran</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                @foreach($record->details as $detail)
                                                    <li>{{ $detail->keterangan }}: Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $totalPengeluaran += $record->jumlah; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total Pengeluaran</th>
                            <th>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Saldo Akhir -->
        <div class="col-md-12">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Saldo Akhir</h5>
                <div class="alert alert-info">
                    <strong>Saldo Akhir:</strong> Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('keuanganLineChart').getContext('2d');
        const labels = [
            @for($i = 1; $i <= 12; $i++)
                '{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}',
            @endfor
        ];
        const pemasukan = [
            @for($i = 1; $i <= 12; $i++)
                {{ $records->where('jenis', 'Pemasukan')->where(function($item) use ($i) { return \Carbon\Carbon::parse($item->tanggal)->month == $i; })->sum('jumlah') }},
            @endfor
        ];
        const pengeluaran = [
            @for($i = 1; $i <= 12; $i++)
                {{ $records->where('jenis', 'Pengeluaran')->where(function($item) use ($i) { return \Carbon\Carbon::parse($item->tanggal)->month == $i; })->sum('jumlah') }},
            @endfor
        ];
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: pemasukan,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.1)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Grafik Keuangan Tahunan' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush
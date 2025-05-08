@extends('admin.layouts')

@section('title', 'Keuangan')

@section('content')

<div class="container">
    <h4 class="mb-4">Transparansi Keuangan</h4>

    <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary mb-4">+ Tambah Data</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                                <td>{{ $record->tanggal }}</td>
                                <td>{{ $record->keterangan }}</td>
                                <td>Rp {{ number_format($record->jumlah, 0, ',', '.') }}</td>
                                <td class="d-flex">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.keuangan.edit', $record->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
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
                            <td>{{ $record->tanggal }}</td>
                            <td>{{ $record->keterangan }}</td>
                            <td>Rp {{ number_format($record->jumlah, 0, ',', '.') }}</td>
                            <td class="d-flex">
                                <!-- Tombol Detail -->
                                <button class="btn btn-info btn-sm me-1" data-toggle="modal" data-target="#detailModal{{ $record->id }}">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.keuangan.edit', $record->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>

                                <!-- Tombol Hapus -->
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
                                            <span>&times;</span>
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
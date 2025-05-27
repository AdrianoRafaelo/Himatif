@extends('admin.layouts')

@section('title', 'Daftar Mahasiswa dari API Kampus')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Mahasiswa dari API Kampus</h1>
            
            <!-- Sync Button -->
            <div>
                <form action="{{ route('admin.campus-students.fetch-and-save') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt"></i> Ambil dan Simpan Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa Aktif</h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Filter by Angkatan -->
                        @if(count($angkatanList) > 0)
                        <div class="mb-4">
                            <form action="{{ route('admin.campus-students.index') }}" method="GET" class="form-inline">
                                <div class="form-group mr-2">
                                    <label for="batch" class="mr-2">Filter Angkatan:</label>
                                    <select class="form-control" id="batch" name="batch" onchange="this.form.submit()">
                                        <option value="all" {{ $selectedBatch == 'all' ? 'selected' : '' }}>Semua Angkatan</option>
                                        @foreach($angkatanList as $angkatan)
                                            <option value="{{ $angkatan }}" {{ $selectedBatch == $angkatan ? 'selected' : '' }}>
                                                Angkatan {{ $angkatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        @endif

                        <!-- Students Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Program Studi</th>
                                        <th>Angkatan</th>
                                        <th>Email</th>
                                        <th>Asrama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td>{{ $student->nim }}</td>
                                            <td>{{ $student->nama }}</td>
                                            <td>{{ $student->prodi_name }}</td>
                                            <td>{{ $student->angkatan }}</td>
                                            <td>{{ $student->email ?? '-' }}</td>
                                            <td>{{ $student->asrama ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="alert alert-info mb-0">
                                                    <i class="fas fa-info-circle"></i> Tidak ada data mahasiswa. Silakan lakukan pengambilan data dengan mengklik tombol "Ambil dan Simpan Data".
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection
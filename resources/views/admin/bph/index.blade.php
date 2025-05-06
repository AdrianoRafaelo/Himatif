@extends('admin.layouts')

@section('title', 'Struktur Organisasi BPH')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Form BPH -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Input Anggota BPH</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->has('error'))
                        <div class="alert alert-danger">{{ $errors->first('error') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.bph.store') }}" method="POST" @if(empty($mahasiswa)) disabled @endif>
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nim">Pilih Mahasiswa</label>
                            <select class="form-control select2" id="nim" name="nim" required @if(empty($mahasiswa)) disabled @endif>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs['nim'] }}">{{ $mhs['nama'] }} ({{ $mhs['nim'] }})</option>
                                @endforeach
                            </select>
                            @error('nim')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if(empty($mahasiswa))
                                <small class="text-danger">Data mahasiswa tidak tersedia. Silakan coba lagi nanti atau login ulang.</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="position">Pilih Posisi</label>
                            <select class="form-control" id="position" name="position" required>
                                <option value="">-- Pilih Posisi --</option>
                                <option value="Ketua">Ketua</option>
                                <option value="Wakil Ketua">Wakil Ketua</option>
                                <option value="Sekertaris 1">Sekertaris 1</option>
                                <option value="Sekertaris 2">Sekertaris 2</option>
                                <option value="Bendahara 1">Bendahara 1</option>
                                <option value="Bendahara 2">Bendahara 2</option>
                            </select>
                            @error('position')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="period">Periode</label>
                            <input type="text" class="form-control" id="period" name="period" placeholder="Contoh: 2025-2026" required pattern="\d{4}-\d{4}">
                            @error('period')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" @if(empty($mahasiswa)) disabled @endif>Simpan Anggota BPH</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel BPH -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-header border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Anggota BPH</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username / NIM</th>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Periode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bphs as $index => $bph)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $bph->user->username }}</td>
                                        <td>{{ $bph->user->nama }}</td>
                                        <td>{{ $bph->position }}</td>
                                        <td>{{ $bph->period }}</td>
                                        <td>
                                            <form action="{{ route('admin.bph.destroy', $bph->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota BPH ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data anggota BPH.</td>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '-- Pilih Mahasiswa --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
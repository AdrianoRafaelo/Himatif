@extends('admin.layouts')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Tambah Event</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Event</h6>
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

                    <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="proker_id">Proker</label>
                            <select name="proker_id" id="proker_id" class="form-control @error('proker_id') is-invalid @enderror" required style="color: #000; background-color: #fff;">
                                <option value="">Pilih Proker</option>
                                @if($prokers->isEmpty())
                                <option value="" disabled>Tidak ada proker tersedia</option>
                                @else
                                @foreach ($prokers as $proker)
                                <option value="{{ $proker->id }}" {{ old('proker_id') == $proker->id ? 'selected' : '' }} style="color: #000;">
                                    {{ $proker->subject ?? 'Nama Proker Tidak Tersedia' }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('proker_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="proposal_id">Proposal (Opsional)</label>
                            <select name="proposal_id" id="proposal_id" class="form-control" style="color: #000; background-color: #fff;">
                                <option value="">Tidak Ada</option>
                                @if($proposals->isEmpty())
                                    <option value="" disabled>Tidak ada proposal tersedia</option>
                                @else
                                    @foreach ($proposals as $proposal)
                                        <option value="{{ $proposal->id }}" {{ old('proposal_id') == $proposal->id ? 'selected' : '' }}>
                                            {{ $proposal->title ?? 'Judul Proposal Tidak Tersedia' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('proposal_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Event</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required>
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required style="color: #000; background-color: #fff;">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="banner_path">Banner</label>
                            <input type="file" name="banner_path" id="banner_path" class="form-control-file @error('banner_path') is-invalid @enderror">
                            @error('banner_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="angkatan_akses" class="form-label">Angkatan yang Bisa Mendaftar</label>
                                <input type="text" name="angkatan_akses" id="angkatan_akses" class="form-control @error('angkatan_akses') is-invalid @enderror" value="{{ old('angkatan_akses') }}" placeholder="Contoh: 2021,2022,2023" {{ old('semua_angkatan') ? 'disabled' : '' }}>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="1" id="semua_angkatan" name="semua_angkatan" {{ old('semua_angkatan') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="semua_angkatan">
                                        Untuk semua angkatan
                                    </label>
                                </div>
                                <small class="text-muted">Pisahkan dengan koma jika lebih dari satu angkatan. Jika memilih "Untuk semua angkatan", input manual akan diabaikan.</small>
                                @error('angkatan_akses')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
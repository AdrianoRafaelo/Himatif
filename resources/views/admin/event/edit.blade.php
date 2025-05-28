@extends('admin.layouts')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Edit Event</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Event</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="proker_id">Proker</label>
                            <select name="proker_id" id="proker_id" class="form-control @error('proker_id') is-invalid @enderror" required>
                                <option value="">Pilih Proker</option>
                                @foreach ($prokers as $proker)
                                    <option value="{{ $proker->id }}" {{ old('proker_id', $event->proker_id) == $proker->id ? 'selected' : '' }}>{{ $proker->subject }}</option>
                                @endforeach
                            </select>
                            @error('proker_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="proposal_id">Proposal</label>
                            <select name="proposal_id" id="proposal_id" class="form-control">
                                <option value="">Tidak Ada</option>
                                @foreach ($proposals as $proposal)
                                    <option value="{{ $proposal->id }}" {{ old('proposal_id', $event->proposal_id) == $proposal->id ? 'selected' : '' }}>{{ $proposal->title }}</option>
                                @endforeach
                            </select>
                            @error('proposal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Event</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $event->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $event->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="scheduled" {{ old('status', $event->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4">{{ old('notes', $event->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="banner_path">Banner</label>
                            <input type="file" name="banner_path" id="banner_path" class="form-control-file @error('banner_path') is-invalid @enderror">
                            @if ($event->banner_path)
                                <img src="{{ Storage::url($event->banner_path) }}" alt="Banner" class="mt-2" style="max-width: 150px; height: auto;">
                            @endif
                            @error('banner_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="angkatan_akses">Angkatan Akses</label>
                            <input type="text" name="angkatan_akses" id="angkatan_akses" class="form-control @error('angkatan_akses') is-invalid @enderror" value="{{ old('angkatan_akses', $event->angkatan_akses) }}">
                            @error('angkatan_akses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

@extends('admin.layouts')

@section('title', 'Edit Proker')

@section('content')
<div class="container">
    <h1>Edit Proker</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proker.update', $proker->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3">
            <label for="subject">Perihal <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $proker->subject) }}" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $proker->description) }}</textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="objective">Tujuan</label>
            <input type="text" class="form-control" id="objective" name="objective" value="{{ old('objective', $proker->objective) }}">
        </div>
        
        <div class="form-group mb-3">
            <label for="location">Lokasi</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $proker->location) }}">
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="planned_date">Rencana Tanggal</label>
                    <input type="date" class="form-control" id="planned_date" name="planned_date" value="{{ old('planned_date', $proker->planned_date) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="actual_date">Realisasi Tanggal</label>
                    <input type="date" class="form-control" id="actual_date" name="actual_date" value="{{ old('actual_date', $proker->actual_date) }}">
                </div>
            </div>
        </div>
        
        <div class="form-group mb-3">
            <label for="funding_source">Sumber Dana</label>
            <input type="text" class="form-control" id="funding_source" name="funding_source" value="{{ old('funding_source', $proker->funding_source) }}">
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="planned_budget">Rencana Anggaran</label>
                    <input type="number" class="form-control" id="planned_budget" name="planned_budget" value="{{ old('planned_budget', $proker->planned_budget) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="actual_budget">Realisasi Anggaran</label>
                    <input type="number" class="form-control" id="actual_budget" name="actual_budget" value="{{ old('actual_budget', $proker->actual_budget) }}">
                </div>
            </div>
        </div>
        
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="Perencanaan" {{ old('status', $proker->status) == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                <option value="Persiapan" {{ old('status', $proker->status) == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                <option value="Pelaksanaan" {{ old('status', $proker->status) == 'Pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
                <option value="Selesai" {{ old('status', $proker->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="period">Periode</label>
            <input type="text" class="form-control" id="period" name="period" value="{{ old('period', $proker->period) }}">
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('proker.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
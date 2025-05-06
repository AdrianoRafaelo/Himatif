@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-4">
    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-lg p-4">
            <h2 class="mb-3">Create News</h2>
            
            <div class="card p-3">
                <h4>Detail Berita</h4>

                <div class="mb-3">
                    <label class="form-label">Judul Berita</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Judul berita..">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Konten</label>
                    <textarea class="form-control" name="content" rows="4" placeholder="Deskripsi">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label class="form-label">Upload Photos</label>
                    <input type="file" class="form-control" name="image">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-success w-100">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection

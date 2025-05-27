@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-lg p-4">
            <h2 class="mb-3">Buat Berita atau Pengumuman</h2>
            
            <div class="card p-3">
                <h4>Detail</h4>

                <div class="mb-3">
                    <label class="form-label">Tipe</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="news" {{ old('type') == 'news' ? 'selected' : '' }}>Berita</option>
                        <option value="announcement" {{ old('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                    </select>
                    @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Judul berita atau pengumuman..">
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
    
                <div class="mb-3" id="image-field">
                    <label class="form-label">Upload Foto (Hanya untuk Berita)</label>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const imageField = document.getElementById('image-field');

        if (typeSelect && imageField) {
            typeSelect.addEventListener('change', function() {
                imageField.style.display = this.value === 'news' ? 'block' : 'none';
            });

            // Set initial state
            imageField.style.display = typeSelect.value === 'news' ? 'block' : 'none';
        } else {
            console.error('Elemen type atau image-field tidak ditemukan!');
        }
    });
</script>
@endsection
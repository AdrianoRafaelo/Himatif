@extends('admin.layouts')

@section('title', 'Edit Berita/Pengumuman')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit {{ $news->type === 'news' ? 'Berita' : 'Pengumuman' }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $news->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Tipe</label>
                            <select name="type" id="type" class="form-control" required disabled>
                                <option value="news" {{ $news->type == 'news' ? 'selected' : '' }}>Berita</option>
                                <option value="announcement" {{ $news->type == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Isi</label>
                            <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content', $news->content) }}</textarea>
                        </div>
                        @if($news->type === 'news')
                        <div class="form-group">
                            <label for="image">Gambar (opsional, max 10MB)</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            @if($news->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="Gambar Berita" style="max-width: 200px; height: auto;">
                                </div>
                            @endif
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

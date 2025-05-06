@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <h1 class="mb-4">Daftar Berita</h1>
    
    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Tambah Berita</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Konten</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($news as $index => $news)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="Gambar" width="100">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $news->title }}</td>
                    <td>{{ Str::limit(strip_tags($news->content), 100) }}</td>
                    <td>
                        <a href="{{ route('news.edit', $news->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('news.destroy', $news->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada berita.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

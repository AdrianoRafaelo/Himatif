@extends('layouts.main')

@section('title', 'News')

@section('content')
<!-- Latest News Section -->
<section class="news-section section-spacing">
    <div class="container">
        <div class="section-header">
            <span class="section-subheading">Kabar Terbaru</span>
            <h2 class="section-title">Berita <span class="text-gradient">& Pengumuman</span></h2>
            <p class="section-description">Tetap terinformasi dengan perkembangan terbaru di HIMATIF</p>
        </div>
        
        <div class="row g-4">
            @forelse ($news as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="news-image">
                        <span class="news-category-tag">Berita</span> {{-- Ganti sesuai kategori jika ada --}}
                    </div>
                    <div class="news-content">
                        <h3 class="title-3 news-title">{{ $item->title }}</h3>
                        <p class="news-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
                        <div class="news-footer">
                            <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Belum ada berita.</p>
            @endforelse
        </div>
        
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline">Lihat Semua Berita <i class="fas fa-arrow-right btn-icon"></i></a>
        </div>
    </div>
</section>
@endsection
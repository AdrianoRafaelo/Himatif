@extends('layouts.main')

@section('title', 'News')

@section('content')
<style>
    /* Scoped styles for news page */
    .news-page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        gap: 20px;
    }

    .section-header {
        margin-bottom: 20px;
    }

    .section-subheading {
        color: #666;
        font-size: 14px;
    }

    .section-title {
        font-size: 28px;
        font-weight: 600;
        color: #2d3748;
    }

    .text-gradient {
        background: none;
        -webkit-background-clip: unset;
        color: inherit;
    }

    .section-description {
        color: #718096;
        font-size: 14px;
    }

    /* Sidebar for Announcements */
    .announcements-sidebar {
        width: 30%;
        background-color: white;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .announcement-item {
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .announcement-item:last-child {
        border-bottom: none;
    }

    .announcement-title {
        font-size: 14px;
        font-weight: 500;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .announcement-date {
        font-size: 12px;
        color: #718096;
    }

    /* News Section */
    .news-section {
        width: 70%;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .col-md-6, .col-lg-4 {
        flex: 1 1 calc(50% - 10px);
    }

    @media (min-width: 992px) {
        .col-lg-4 {
            flex: 1 1 calc(33.33% - 13.33px);
        }
    }

    .card {
        background-color: white;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .news-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .news-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .news-category-tag, .news-latest-tag {
        position: absolute;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .news-category-tag {
        top: 10px;
        left: 10px;
        background: none;
        color: inherit;
    }

    .news-latest-tag {
        top: 10px;
        right: 10px;
        background-color: #ff4d4f;
        color: white;
    }

    .news-content {
        padding: 15px;
    }

    .news-title {
        font-size: 18px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .news-date {
        font-size: 12px;
        color: #718096;
        margin-bottom: 10px;
    }

    .news-excerpt {
        font-size: 14px;
        color: #4a5568;
        margin-bottom: 15px;
    }

    .btn-text {
        color: #3490dc;
        text-decoration: none;
        font-weight: 500;
    }

    .btn-text:hover {
        text-decoration: underline;
    }

    .text-center {
        text-align: center;
    }
</style>

<!-- Main Layout -->
 <div class="section-header">
            <span class="section-subheading">Kabar Terbaru</span>
            <h2 class="section-title">Berita <span class="text-gradient">& Pengumuman</span></h2>
            <p class="section-description">Tetap terinformasi dengan perkembangan terbaru di HIMATIF</p>
        </div>
<div class="news-page-wrapper">
    <div class="announcements-sidebar">
        <h3>Pengumuman</h3>
        @forelse ($announcements as $item)
            <div class="announcement-item">
                <div class="announcement-title">{{ $item->title }}</div>
                <div class="announcement-date">{{ $item->published_at->format('d-m-Y ') }}</div>
            </div>
        @empty
            <p class="text-center">Tidak ada pengumuman.</p>
        @endforelse
    </div>

    <div class="news-section">
        <div class="section-header">
            <h2 class="section-title">Berita</h2>
        </div>
        
        <div class="row">
            @forelse ($news as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder.jpg') }}" alt="{{ $item->title }}" class="news-image">
                        @if ($item->published_at->gt(now()->subDays(3)))
                            <span class="news-latest-tag">Terbaru</span>
                        @endif

                    </div>
                    <div class="news-content">
                        <h3 class="news-title">{{ $item->title }}</h3>
                        <p class="news-date">{{ $item->published_at->format('d M Y') }}</p>
                        <p class="news-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
                        <div class="news-footer">
                            <a href="#" class="btn-text" data-bs-toggle="modal" data-bs-target="#newsModal{{ $item->id }}">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center">Belum ada berita.</p> 
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Detail Berita -->
@foreach ($news as $item)
<div class="modal fade" id="newsModal{{ $item->id }}" tabindex="-1" aria-labelledby="newsModalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newsModalLabel{{ $item->id }}">{{ $item->title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/placeholder.jpg') }}" alt="{{ $item->title }}" class="img-fluid mb-3" style="max-height:300px;object-fit:cover;">
        <p class="text-muted mb-2">{{ $item->published_at->format('d M Y') }}</p>
        <div>{!! $item->content !!}</div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
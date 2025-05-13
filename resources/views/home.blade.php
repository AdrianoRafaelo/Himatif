@extends('layouts.main')

@section('content')

<section class="feature-section section-spacing">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="section-subheading">Selamat Datang di</span>
                <h1 class="display-title">Himpunan Mahasiswa <span class="text-gradient">Teknologi Informasi</span></h1>
                <p class="body-large mb-4">Wadah bagi mahasiswa Teknik Informatika untuk mengembangkan potensi akademik, soft skill, dan memperluas jaringan profesional.</p>
                <p class="body mb-5">HIMATIF berkomitmen untuk memfasilitasi pengembangan mahasiswa melalui berbagai kegiatan yang memberdayakan dan membuka peluang karir di dunia teknologi informasi.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('tentang') }}" class="btn btn-primary">Tentang Kami</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1530099486328-e021101a494a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Mahasiswa Teknik Informatika" class="img-fluid rounded shadow-lg">
                    <div class="card position-absolute" style="bottom: -20px; right: 20px; max-width: 200px;">
                        <div class="d-flex align-items-center p-3">
                            <div class="stats-icon me-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h3 class="fs-4 fw-bold mb-0 text-gradient">500+</h3>
                                <p class="body-small text-secondary mb-0">Anggota Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Events Section -->
<section class="events-section section-spacing">
    <div class="container">
        <div class="section-header">
            <span class="section-subheading">Kalender Kegiatan</span>
            <h2 class="section-title">Acara <span class="text-gradient">Mendatang</span></h2>
            <p class="section-description">Ikuti berbagai acara menarik yang akan diselenggarakan oleh HIMATIF</p>
        </div>
        
        @if ($events->isEmpty())
    <p>Tidak ada event yang tersedia saat ini.</p>
    @else
    <div class="row">
        @foreach ($events as $event)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card event-card h-100 shadow-sm">
                <div class="event-image-wrapper position-relative">
                    @if($event->banner_path)
                    <img src="{{ asset('storage/' . $event->banner_path) }}" alt="{{ $event->name }}" class="event-image w-100" style="height: 220px; object-fit: cover;">
                    @else
                    <div style="height: 220px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">No Image</div>
                    @endif

                    <!-- Tag Tanggal -->
                    <div class="position-absolute top-0 start-0 m-2 text-center px-2 py-1 rounded bg-white bg-opacity-75">
                        <span class="d-block fw-bold" style="font-size: 1.4rem; line-height: 1;">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
                        <span style="font-size: 0.8rem;">{{ strtoupper(\Carbon\Carbon::parse($event->start_date)->format('M')) }}</span>
                    </div>
                </div>

                <div class="event-content p-3">
                    <div class="event-meta mb-2 text-muted small">
                        <div class="event-meta-item mb-1">
                            <i class="far fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }} WIB
                        </div>
                        <div class="event-meta-item">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}
                        </div>
                    </div>

                    <h5 class="event-title mb-2">{{ $event->name }}</h5>
                    <p class="event-description text-muted mb-3">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>

                    <div class="event-footer d-flex justify-content-between align-items-center">
                        <!-- Status Warna -->
                        @php
                            $status = strtolower($event->status);
                            $statusColor = match($status) {
                                'completed' => 'text-success',
                                'cancelled' => 'text-danger',
                                default => 'text-secondary'
                            };
                        @endphp
                        <span class="{{ $statusColor }} fw-bold text-capitalize">{{ $event->status }}</span>

                        @if(session('user') && session('user')['role'] === 'mahasiswa')
                        <a href="{{ route('student.register.create', $event->id) }}" class="btn btn-sm btn-outline-primary">
                            Daftar <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif            
                    
        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline">Lihat Semua Acara <i class="fas fa-arrow-right btn-icon"></i></a>
        </div>
    </div>
</section>

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
            <a href="{{ route('news') }}" class="btn btn-outline">Lihat Semua Berita <i class="fas fa-arrow-right btn-icon"></i></a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section section-spacing">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="card stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stats-number">25+</div>
                    <h4 class="stats-label">Kompetisi Dimenangkan</h4>
                </div>
            </div>
            
            <div class="col-6 col-md-3">
                <div class="card stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number">1000+</div>
                    <h4 class="stats-label">Alumni Sukses</h4>
                </div>
            </div>
            
            <div class="col-6 col-md-3">
                <div class="card stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="stats-number">15+</div>
                    <h4 class="stats-label">Kerjasama Industri</h4>
                </div>
            </div>
            
            <div class="col-6 col-md-3">
                <div class="card stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="stats-number">50+</div>
                    <h4 class="stats-label">Proyek Dikembangkan</h4>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Partners Section -->
<section class="partners-section section-spacing">
    <div class="container">
        <div class="section-header">
            <span class="section-subheading">Kolaborasi</span>
            <h2 class="section-title">Mitra <span class="text-gradient">Kami</span></h2>
            <p class="section-description">Berkolaborasi dengan perusahaan dan institusi terkemuka untuk memberikan pengalaman terbaik</p>
        </div>
        
        <div class="partners-grid">
            <div class="partner-item">
                <img src="https://via.placeholder.com/150x50?text=Partner+1" alt="Partner 1">
            </div>
            <div class="partner-item">
                <img src="https://via.placeholder.com/150x50?text=Partner+2" alt="Partner 2">
            </div>
            <div class="partner-item">
                <img src="https://via.placeholder.com/150x50?text=Partner+3" alt="Partner 3">
            </div>
            <div class="partner-item">
                <img src="https://via.placeholder.com/150x50?text=Partner+4" alt="Partner 4">
            </div>
            <div class="partner-item">
                <img src="https://via.placeholder.com/150x50?text=Partner+5" alt="Partner 5">
            </div>
            <div class="partner-item">
                <img src="https://via.placeholder.com/150x50?text=Partner+6" alt="Partner 6">
            </div>
        </div>
    </div>
</section>
@endsection 
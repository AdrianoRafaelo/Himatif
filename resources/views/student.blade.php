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
                    <a href="#" class="btn btn-primary">Tentang Kami</a>
                    <a href="#" class="btn btn-outline">Gabung Bersama Kami</a>
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

<!-- Seksi Acara Unggulan -->
<section class="events-section section-spacing">
    <div class="container">
        <div class="section-header">
            <span class="section-subheading">Kalender Kegiatan</span>
            <h2 class="section-title">Acara <span class="text-gradient">Mendatang</span></h2>
            <p class="section-description">Ikuti berbagai acara menarik yang akan diselenggarakan oleh HIMATIF</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card event-card">
                    <div class="event-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Webinar Teknologi" class="event-image">
                        <div class="event-date-tag">
                            <span class="event-day">25</span>
                            <span class="event-month">Nov</span>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="far fa-clock"></i> 14:00 - 16:00 WIB
                            </div>
                            <div class="event-meta-item">
                                <i class="fas fa-map-marker-alt"></i> Auditorium
                            </div>
                        </div>
                        <h3 class="title-3 event-title">Artificial Intelligence: Masa Depan Teknologi</h3>
                        <p class="event-description">Webinar interaktif tentang perkembangan AI dan dampaknya terhadap industri teknologi di masa depan.</p>
                        <div class="event-footer">
                            <span class="badge badge-primary event-category">Webinar</span>
                            <a href="#" class="btn btn-text">Daftar <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card event-card">
                    <div class="event-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Workshop Coding" class="event-image">
                        <div class="event-date-tag">
                            <span class="event-day">10</span>
                            <span class="event-month">Des</span>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="far fa-clock"></i> 09:00 - 16:00 WIB
                            </div>
                            <div class="event-meta-item">
                                <i class="fas fa-map-marker-alt"></i> Lab Komputer
                            </div>
                        </div>
                        <h3 class="title-3 event-title">Bootcamp Web Development</h3>
                        <p class="event-description">Workshop intensif 3 hari untuk mempelajari dasar-dasar pengembangan web modern menggunakan React dan Node.js.</p>
                        <div class="event-footer">
                            <span class="badge badge-primary event-category">Workshop</span>
                            <a href="#" class="btn btn-text">Daftar <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card event-card">
                    <div class="event-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Kompetisi Coding" class="event-image">
                        <div class="event-date-tag">
                            <span class="event-day">15</span>
                            <span class="event-month">Jan</span>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="far fa-clock"></i> 08:00 - 20:00 WIB
                            </div>
                            <div class="event-meta-item">
                                <i class="fas fa-map-marker-alt"></i> Gedung Serbaguna
                            </div>
                        </div>
                        <h3 class="title-3 event-title">Hackathon: Solusi Digital untuk Pendidikan</h3>
                        <p class="event-description">Kompetisi pemrograman 12 jam untuk mengembangkan aplikasi inovatif yang memecahkan masalah pendidikan.</p>
                        <div class="event-footer">
                            <span class="badge badge-primary event-category">Kompetisi</span>
                            <a href="#" class="btn btn-text">Daftar <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline">Lihat Semua Acara <i class="fas fa-arrow-right btn-icon"></i></a>
        </div>
    </div>
</section>

<!-- Seksi Berita Terbaru -->
<section class="news-section section-spacing">
    <div class="container">
        <div class="section-header">
            <span class="section-subheading">Kabar Terbaru</span>
            <h2 class="section-title">Berita <span class="text-gradient">& Pengumuman</span></h2>
            <p class="section-description">Tetap terinformasi dengan perkembangan terbaru di HIMATIF</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Pengumuman HIMATIF" class="news-image">
                    </div>
                    <div class="news-content">
                        <h3 class="title-3 news-title">Pendaftaran Anggota HIMATIF 2025 Dibuka</h3>
                        <p class="news-description">Jangan lewatkan kesempatan untuk bergabung dengan HIMATIF dan kembangkan potensi dirimu bersama kami!</p>
                        <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Pengumuman HIMATIF" class="news-image">
                    </div>
                    <div class="news-content">
                        <h3 class="title-3 news-title">Workshop Data Science untuk Pemula</h3>
                        <p class="news-description">Belajar tentang dasar-dasar data science dan bagaimana memulai perjalanan karirmu di bidang ini.</p>
                        <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Pengumuman HIMATIF" class="news-image">
                    </div>
                    <div class="news-content">
                        <h3 class="title-3 news-title">HIMATIF Gelar Lomba Pemrograman Nasional</h3>
                        <p class="news-description">Ikuti lomba pemrograman tingkat nasional yang diadakan oleh HIMATIF untuk mengasah keterampilan codingmu!</p>
                        <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline">Lihat Semua Berita <i class="fas fa-arrow-right btn-icon"></i></a>
        </div>
    </div>
</section>
@endsection

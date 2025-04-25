@extends('layouts.main')

@section('content')
<!-- Welcome Section -->
<section class="feature-section section-spacing">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="section-subheading">Selamat Datang di</span>
                <h1 class="display-title">Himpunan Mahasiswa <span class="text-gradient">Teknik Informatika</span></h1>
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

<!-- Featured Events Section -->
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

<!-- Latest News Section -->
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
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Kunjungan Industri" class="news-image">
                        <span class="news-category-tag">Prestasi</span>
                    </div>
                    <div class="news-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i> 20 Oktober 2023
                        </div>
                        <h3 class="title-3 news-title">Tim HIMATIF Raih Juara 1 Kompetisi IoT Nasional</h3>
                        <p class="news-excerpt">Tim mahasiswa HIMATIF berhasil menyabet juara pertama dalam ajang kompetisi Internet of Things tingkat nasional yang diselenggarakan oleh...</p>
                        <div class="news-footer">
                            <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Rapat Kerja" class="news-image">
                        <span class="news-category-tag">Kegiatan</span>
                    </div>
                    <div class="news-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i> 15 Oktober 2023
                        </div>
                        <h3 class="title-3 news-title">Rapat Kerja Pengurus HIMATIF Periode 2023/2024</h3>
                        <p class="news-excerpt">Pengurus HIMATIF periode 2023/2024 mengadakan rapat kerja untuk merancang program kerja selama satu tahun ke depan. Dalam rapat ini dibahas...</p>
                        <div class="news-footer">
                            <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card">
                    <div class="news-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1560439514-4e9645039924?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Pembukaan Pendaftaran" class="news-image">
                        <span class="news-category-tag">Pengumuman</span>
                    </div>
                    <div class="news-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i> 5 Oktober 2023
                        </div>
                        <h3 class="title-3 news-title">Pembukaan Pendaftaran Asisten Praktikum Semester Ganjil</h3>
                        <p class="news-excerpt">HIMATIF membuka pendaftaran untuk menjadi asisten praktikum pada semester ganjil tahun akademik 2023/2024. Beberapa mata kuliah yang...</p>
                        <div class="news-footer">
                            <a href="#" class="btn btn-text">Baca Selengkapnya <i class="fas fa-arrow-right btn-icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline">Lihat Semua Berita <i class="fas fa-arrow-right btn-icon"></i></a>
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

<!-- Departments Section -->
<section class="departments-section section-spacing">
    <div class="container">
        <div class="section-header">
            <span class="section-subheading">Bidang Kepengurusan</span>
            <h2 class="section-title">Departemen <span class="text-gradient">HIMATIF</span></h2>
            <p class="section-description">Mengenal lebih dekat struktur organisasi dan bidang kepengurusan kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card department-card">
                    <div class="department-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="title-3 department-title">Departemen Pendidikan</h3>
                    <p class="department-description">Bertanggung jawab untuk mengembangkan kegiatan akademik dan meningkatkan kualitas pendidikan mahasiswa.</p>
                    <ul class="department-list">
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Asisten Praktikum
                        </li>
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Bimbingan Belajar
                        </li>
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Seminar Pendidikan
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card department-card">
                    <div class="department-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="title-3 department-title">Departemen Pengembangan Karir</h3>
                    <p class="department-description">Fokus pada persiapan mahasiswa menghadapi dunia kerja dan pengembangan soft skills.</p>
                    <ul class="department-list">
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Workshop Keterampilan
                        </li>
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Kunjungan Industri
                        </li>
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Job Fair
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card department-card">
                    <div class="department-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="title-3 department-title">Departemen Riset & Teknologi</h3>
                    <p class="department-description">Mengkoordinasikan kegiatan riset dan pengembangan teknologi bagi anggota HIMATIF.</p>
                    <ul class="department-list">
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Penelitian Mahasiswa
                        </li>
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Hackathon
                        </li>
                        <li class="department-list-item">
                            <i class="fas fa-check-circle"></i> Study Group
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Bergabung dengan HIMATIF</h2>
            <p class="cta-description">Jadi bagian dari komunitas mahasiswa informatika, kembangkan potensimu, dan bangun jaringan profesional sejak dini.</p>
            <a href="#" class="btn btn-light">Daftar Sekarang <i class="fas fa-arrow-right btn-icon"></i></a>
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
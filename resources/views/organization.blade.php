@extends('layouts.main')

@section('title', 'Organisasi HMIF')

@section('content')
<style>
    /* Main Container */
    .organization-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eaeaea;
    }
    
    .page-header h1 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    /* Filter Section */
    .filter-container {
        margin-bottom: 30px;
    }
    
    .period-selector {
        max-width: 400px;
        margin: 0 auto;
    }
    
    /* Section Headers */
    .section-header {
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
        color: #2c3e50;
    }
    
    .section-header + .text-muted {
        font-size: 0.9rem;
        text-align: center;
        color: #7f8c8d;
    }
    
    /* BPH Cards */
    .bph-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    
    .bph-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        border: 1px solid #eaeaea;
        text-align: center;
        opacity: 0;
        transform: translateY(20px);
    }
    
    .bph-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .bph-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        border-color: #3498db;
        opacity: 0.95;
    }
    
    .bph-card.ketua {
        background-color: #e6f3ff;
        border-left: 4px solid #3498db;
    }
    
    .bph-card.wakil-ketua {
        background-color: #f0f8ff;
        border-left: 4px solid #2980b9;
    }
    
    .bph-card-body {
        padding: 20px;
    }
    
    .bph-card-body img {
        display: block;
        margin: 0 auto 15px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .bph-name {
        font-size: 1.2rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    .bph-position {
        font-weight: 600;
        color: #3498db;
        margin-bottom: 5px;
    }
    
    .bph-period {
        color: #7f8c8d;
        font-size: 0.9rem;
    }
    
    /* Proker Cards */
    .proker-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .proker-card, .bph-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid #eaeaea;
    }
    
    .proker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: #3498db;
    }
    
    .proker-card-header {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eaeaea;
    }
    
    .proker-card-header h5 {
        font-size: 1.1rem;
        color: #2c3e50;
        margin: 0;
    }
    
    .proker-card-body {
        padding: 15px 20px;
    }
    
    /* Status Badge Styles */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-planned {
        background-color: #3498db;
        color: white;
    }
    
    .status-ongoing {
        background-color: #f39c12;
        color: white;
    }
    
    .status-completed {
        background-color: #2ecc71;
        color: white;
    }
    
    .status-canceled {
        background-color: #e74c3c;
        color: white;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        margin: 30px 0;
        grid-column: 1 / -1;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #bdc3c7;
        margin-bottom: 20px;
    }
    
    .empty-state h4 {
        color: #7f8c8d;
        margin-bottom: 15px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .bph-grid,
        .proker-grid {
            grid-template-columns: 1fr;
        }
        .bph-card {
            margin: 0 auto 20px;
            max-width: 300px;
        }
        .period-selector {
            max-width: 100%;
        }
    }
    @media (max-width: 480px) {
        .bph-card-body h3 {
            font-size: 1.1rem;
        }
        .bph-card-body p {
            font-size: 0.9rem;
        }
    }
</style>

<div class="organization-container">
    <div class="page-header">
        <h1>Organisasi HMIF</h1>
        <p class="text-muted">Struktur organisasi dan program kerja HMIF</p>
    </div>

    <!-- Filter Periode -->
    <div class="filter-container">
        <div class="period-selector">
            <form action="{{ route('organization') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="period" onchange="this.form.submit()">
                        @foreach($periods as $p)
                            <option value="{{ $p }}" {{ $p == $period ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter Periode
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Struktur BPH -->
    <div class="mb-5">
        <h2 class="section-header">Struktur BPH Periode {{ $period }}</h2>
        <p class="text-muted mb-4">Struktur kepengurusan Himpunan Mahasiswa Informatika untuk periode ini.</p>
        @if($bphs->isEmpty())
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h4>Tidak ada anggota BPH untuk periode {{ $period }}</h4>
                <p>Silakan pilih periode lain atau hubungi admin untuk informasi lebih lanjut</p>
            </div>
        @else
            <div class="bph-grid">
                @foreach($bphs as $bph)
                    <div class="bph-card {{ strtolower(str_replace(' ', '-', $bph->position)) }}">
                        <div class="bph-card-body text-center">
                            <img src="https://robohash.org/{{ urlencode($bph->user->nama ?? $bph->user->username) }}?set=set1" alt="{{ $bph->user->nama ?? 'Unknown' }}" class="rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <h3 class="bph-name">{{ $bph->user->nama ?? 'Nama Tidak Diketahui' }}</h3>
                            <p class="bph-position"><i class="fas fa-user-tie"></i> {{ $bph->position }}</p>
                            <p class="bph-period"><i class="fas fa-calendar-alt"></i> {{ $bph->period }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Daftar Proker -->
    <div class="mb-5">
        <h2 class="section-header">Program Kerja Periode {{ $period }}</h2>
        @if($prokers->isEmpty())
            <div class="empty-state">
                <i class="far fa-folder-open"></i>
                <h4>Tidak ada program kerja untuk periode {{ $period }}</h4>
                <p>Silakan pilih periode lain atau hubungi admin untuk informasi lebih lanjut</p>
            </div>
        @else
            <div class="proker-grid">
                @foreach($prokers as $proker)
                    <div class="proker-card">
                        <div class="proker-card-header">
                            <h5><i class="fas fa-file-alt"></i> {{ $proker->subject }}</h5>
                        </div>
                        <div class="proker-card-body">
                            <ul class="list-unstyled mb-3">
                                <li><i class="fas fa-map-marker-alt"></i> <strong>Lokasi:</strong> {{ $proker->location ?? '-' }}</li>
                                <li><i class="far fa-calendar"></i> <strong>Rencana Tanggal:</strong> {{ $proker->planned_date ? \Carbon\Carbon::parse($proker->planned_date)->translatedFormat('F Y') : '-' }}</li>
                                <li><i class="fas fa-calendar-day"></i> <strong>Periode:</strong> {{ $proker->period }}</li>
                                <li><i class="fas fa-info-circle"></i> <strong>Status:</strong> 
                                    <span class="status-badge status-{{ strtolower($proker->status) }}">
                                        {{ $proker->status }}
                                    </span>
                                </li>
                            </ul>

                            <!-- Tombol Buka Modal -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#prokerModal{{ $proker->id }}">
                                Lihat Detail
                            </button>
                        </div>
                    </div>

                    <!-- Modal untuk Detail Proker -->
                    <div class="modal fade" id="prokerModal{{ $proker->id }}" tabindex="-1" aria-labelledby="prokerModalLabel{{ $proker->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="prokerModalLabel{{ $proker->id }}">
                                        {{ $proker->subject }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Deskripsi:</strong><br>{{ $proker->description }}</p>
                                    <p><strong>Tujuan:</strong><br>{{ $proker->objective ?? '-' }}</p>
                                    <p><strong>Lokasi:</strong> {{ $proker->location ?? '-' }}</p>
                                    <p><strong>Rencana Tanggal:</strong> {{ $proker->planned_date ? \Carbon\Carbon::parse($proker->planned_date)->translatedFormat('d F Y') : '-' }}</p>
                                    <p><strong>Realisasi Tanggal:</strong> {{ $proker->actual_date ? \Carbon\Carbon::parse($proker->actual_date)->translatedFormat('d F Y') : '-' }}</p>
                                    <p><strong>Periode:</strong> {{ $proker->period }}</p>
                                    <p><strong>Status:</strong>
                                        <span class="status-badge status-{{ strtolower($proker->status) }}">
                                            {{ $proker->status }}
                                        </span>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $prokers->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.bph-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('visible');
            }, index * 200); // Delay 200ms per kartu
        });
    });
</script>
@endsection
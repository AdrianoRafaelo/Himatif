@extends('layouts.main')

@section('title', 'Event')

@section('content')

<!-- <style>
    /* Main Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header Section */
    .text-center {
        margin-bottom: 3rem;
    }

    .fw-bold {
        font-weight: 700;
        font-size: 2.5rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .text-muted {
        color: #64748b;
        font-size: 1.1rem;
    }

    /* Event Cards */
    .event-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .event-image-wrapper {
        overflow: hidden;
        border-radius: 12px 12px 0 0;
    }

    .event-image {
        transition: transform 0.5s ease;
    }

    .event-card:hover .event-image {
        transform: scale(1.05);
    }

    .event-date-tag {
        border-radius: 12px 0 12px 0;
        width: 60px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6) !important;
    }

    .event-day {
        font-size: 1.5rem;
        line-height: 1;
    }

    .event-month {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.75rem;
    }

    .card-text {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        margin-bottom: 1rem;
    }

    .event-meta i {
        width: 16px;
        text-align: center;
    }

    .card-footer {
        border-top: none;
        padding: 1rem 1.5rem;
        border-radius: 0 0 12px 12px;
    }

    .badge {
        font-weight: 500;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        background: linear-gradient(135deg, #10b981, #3b82f6);
    }

    .btn-link {
        color: #3b82f6 !important;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 0 !important;
    }

    .btn-link:hover {
        color: #2563eb !important;
    }

    .btn-link i {
        transition: transform 0.3s ease;
    }

    .btn-link:hover i {
        transform: translateX(3px);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem 1.5rem 0.5rem;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.5rem;
        color: #1e293b;
    }

    .modal-body {
        padding: 0 1.5rem 1.5rem;
    }

    .modal-body img {
        border-radius: 12px;
        margin-bottom: 1.5rem;
        width: 100%;
        max-height: 300px;
        object-fit: cover;
    }

    .modal-body p {
        margin-bottom: 1rem;
        line-height: 1.7;
        color: #475569;
    }

    .modal-body strong {
        color: #1e293b;
        font-weight: 600;
    }

    .modal-footer {
        border-top: none;
        padding: 0 1.5rem 1.5rem;
        justify-content: flex-start;
    }

    .btn-secondary {
        background-color: #f1f5f9;
        color: #475569;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #e2e8f0;
    }

    /* Empty State */
    .col-12.text-center {
        padding: 3rem 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .fw-bold {
            font-size: 2rem;
        }
        
        .text-muted {
            font-size: 1rem;
        }
        
        .modal-dialog {
            margin: 1rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .event-card {
        animation: fadeIn 0.6s ease forwards;
        animation-delay: calc(var(--order) * 0.1s);
        opacity: 0;
    }
</style> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation delays to cards
        const cards = document.querySelectorAll('.event-card');
        cards.forEach((card, index) => {
            card.style.setProperty('--order', index);
        });
    });
</script>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Event Terbaru</h2>
        <p class="text-muted">Jangan lewatkan event seru dari program kerja kami!</p>
    </div>

    <div class="row">
        @forelse($events as $event)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card event-card shadow border-0">
                <div class="event-image-wrapper position-relative">
                    <img src="{{ $event->banner_path ? asset('storage/' . $event->banner_path) : asset('img/default.jpg') }}"
                         alt="{{ $event->name }}" class="event-image img-fluid w-100" style="height: 200px; object-fit: cover;">
                    <div class="event-date-tag position-absolute top-0 start-0 bg-primary text-white text-center px-2 py-1">
                        <div class="event-day fw-bold">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</div>
                        <div class="event-month">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="event-meta mb-2 text-muted small">
                        <div><i class="far fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }} WIB
                        </div>
                        <div><i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}</div>
                    </div>
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary">{{ $event->proker->subject ?? 'Lainnya' }}</span>
                    <button class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->id }}">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Tidak ada event yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Modals --}}
@foreach($events as $event)
<div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1" aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel{{ $event->id }}">{{ $event->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <img src="{{ $event->banner_path ? asset('storage/' . $event->banner_path) : asset('img/default.jpg') }}"
                     alt="{{ $event->name }}" class="img-fluid mb-3">

                <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                <p><strong>Waktu:</strong>
                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }} -
                    {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y H:i') }} WIB
                </p>
                <p><strong>Deskripsi:</strong></p>
                <p>{{ $event->description }}</p>
                @if ($event->notes)
                    <p><strong>Catatan:</strong> {{ $event->notes }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush

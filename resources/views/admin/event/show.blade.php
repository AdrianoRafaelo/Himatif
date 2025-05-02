@extends('admin.layouts')

@section('title', 'Detail Event')

@section('content')
<style>
    /* Main Container */
    .container-fluid {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    /* Header Section */
    .d-flex.justify-content-between {
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .card-body {
        padding: 2.5rem;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #3b82f6;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
        position: relative;
    }

    .card-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    }

    /* Content Styling */
    p {
        font-size: 1rem;
        line-height: 1.7;
        color: #4a5568;
        margin-bottom: 1rem;
    }

    p strong {
        color: #2d3748;
        font-weight: 600;
        min-width: 150px;
        display: inline-block;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: capitalize;
    }

    .bg-primary {
        background-color: #3b82f6 !important;
    }

    .bg-success {
        background-color: #10b981 !important;
    }

    .bg-danger {
        background-color: #ef4444 !important;
    }

    .bg-secondary {
        background-color: #64748b !important;
    }

    /* Image Styling */
    .img-fluid {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .img-fluid:hover {
        transform: scale(1.02);
    }

    /* Button Styling */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .btn i {
        font-size: 0.9rem;
        transition: transform 0.2s ease;
    }

    .btn:hover i {
        transform: translateX(-3px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 1rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        h1 {
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        p strong {
            display: block;
            margin-bottom: 0.25rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <h1>Detail Event: {{ $event->name }}</h1>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Event
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Event</h5>
            <p><strong>Nama Event:</strong> {{ $event->name }}</p>
            <p><strong>Deskripsi:</strong> {{ $event->description ?? 'Tidak ada deskripsi' }}</p>
            <p><strong>Lokasi:</strong> {{ $event->location }}</p>
            <p><strong>Tanggal:</strong> {{ $event->start_date->format('d M Y') }} s/d {{ $event->end_date->format('d M Y') }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($event->status == 'scheduled') bg-primary
                    @elseif($event->status == 'completed') bg-success
                    @elseif($event->status == 'cancelled') bg-danger
                    @else bg-secondary @endif">
                    {{ ucfirst($event->status) }}
                </span>
            </p>
            <p><strong>Catatan:</strong> {{ $event->notes ?? 'Tidak ada catatan' }}</p>
            
            @if($event->banner_path)
            <div class="mb-3">
                <strong>Banner:</strong>
                <img src="{{ asset('storage/' . $event->banner_path) }}" alt="Banner" class="img-fluid mt-2">
            </div>
            @endif

            <h5 class="card-title">Program Kerja (Proker)</h5>
            <p><strong>Proker:</strong> {{ $event->proker->subject }}</p>
            <p><strong>Proposal:</strong> 
                @if($event->proposal)
                    {{ $event->proposal->title }} ({{ $event->proposal->status }})
                @else
                    Tidak ada proposal terkait
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

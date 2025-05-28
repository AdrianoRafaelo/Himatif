@extends('layouts.main')

@section('content')
<style>
    .event-card {
        border: none;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s;
    }
    .event-card:hover {
        transform: translateY(-5px);
    }
    .event-date-tag {
        width: 50px;
    }
    .event-image {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    .section-title {
        margin-top: 2rem;
        margin-bottom: 1.5rem;
        font-weight: bold;
        color: #333;
    }
    .divider {
        margin: 2rem 0;
        height: 3px;
        background: #000; /* Straight black line */
        border: none;
    }
</style>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Daftar Event</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($scheduledEvents->isEmpty() && $completedEvents->isEmpty() && $cancelledEvents->isEmpty())
    <p>Tidak ada Event yang tersedia saat ini.</p>
    @else
    <!-- Scheduled Events -->
    @if ($scheduledEvents->isNotEmpty())
    <h3 class="section-title">Scheduled Events</h3>
    <div class="row">
        @foreach ($scheduledEvents as $event)
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
                        <span class="fw-bold" style="font-size: 1.1rem; line-height: 1;">
                            {{ strtoupper(\Carbon\Carbon::parse($event->start_date)->format('M')) }}
                        </span>
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
                            @php
                                $isRegistered = \App\Models\StudentRegistration::where('event_id', $event->id)
                                    ->where('username', session('user')['username'])
                                    ->exists();
                            @endphp
                            @if($isRegistered)
                                <span class="btn btn-sm btn-outline-secondary disabled">Sudah Terdaftar</span>
                            @else
                                <a href="{{ route('student.register.create', $event->id) }}" class="btn btn-sm btn-outline-primary">
                                    Daftar <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Divider after Scheduled Events -->
    @if ($scheduledEvents->isNotEmpty() && ($completedEvents->isNotEmpty() || $cancelledEvents->isNotEmpty()))
    <hr class="divider">
    @endif

    <!-- Completed Events -->
    @if ($completedEvents->isNotEmpty())
    <h3 class="section-title">Completed Events</h3>
    <div class="row">
        @foreach ($completedEvents as $event)
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
                        <span class="fw-bold" style="font-size: 1.1rem; line-height: 1;">
                            {{ strtoupper(\Carbon\Carbon::parse($event->start_date)->format('M')) }}
                        </span>
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
                            <span class="btn btn-sm btn-outline-secondary disabled">Pendaftaran Ditutup</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Divider after Completed Events -->
    @if ($completedEvents->isNotEmpty() && $cancelledEvents->isNotEmpty())
    <hr class="divider">
    @endif

    <!-- Cancelled Events -->
    @if ($cancelledEvents->isNotEmpty())
    <h3 class="section-title">Cancelled Events</h3>
    <div class="row">
        @foreach ($cancelledEvents as $event)
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
                        <span class="fw-bold" style="font-size: 1.1rem; line-height: 1;">
                            {{ strtoupper(\Carbon\Carbon::parse($event->start_date)->format('M')) }}
                        </span>
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
                            <span class="btn btn-sm btn-outline-secondary disabled">Pendaftaran Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @endif
</div>
@endsection

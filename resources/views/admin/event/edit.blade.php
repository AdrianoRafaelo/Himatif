@extends('admin.layouts')

@section('title', 'Edit Event')

@section('content')
<style>
    /* Main Container - Glass Morphism Effect */
    .container-fluid {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2.5rem;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    /* Title with Gradient Text */
    h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 2.5rem;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        position: relative;
        padding-bottom: 1rem;
    }

    h1::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    /* Form Elements - Modern Style */
    .form-label {
        display: block;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.8rem;
        font-size: 1rem;
        letter-spacing: 0.3px;
    }

    .form-control {
        width: 100%;
        padding: 1rem 1.2rem;
        font-size: 0.95rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: rgba(249, 250, 251, 0.7);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background-color: #fff;
    }

    /* Floating Label Effect */
    .form-group {
        position: relative;
        margin-bottom: 2rem;
    }

    .form-group.focused .form-label {
        transform: translateY(-120%) scale(0.9);
        color: #6366f1;
    }

    /* Select Dropdown - Custom Arrow */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' viewBox='0 0 20 20' fill='%236b7280'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd' /%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.2rem;
    }

    /* File Input - Modern Style */
    input[type="file"] {
        padding: 0;
        border: 2px dashed #e5e7eb;
        background-color: rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
    }

    input[type="file"]:hover {
        border-color: #a5b4fc;
        background-color: rgba(239, 246, 255, 0.5);
    }

    input[type="file"]::file-selector-button {
        padding: 0.75rem 1.25rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        border-radius: 8px;
        margin-right: 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    input[type="file"]::file-selector-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
    }

    /* Buttons - Animated Gradient */
    .btn {
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        cursor: pointer;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #3b82f6);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #3b82f6, #10b981);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: -1;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover::before {
        opacity: 1;
    }

    .btn-secondary {
        background: white;
        color: #4b5563;
        border: 2px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary:hover {
        background: #f9fafb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    /* Button Icons */
    .btn i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .btn:hover i {
        transform: scale(1.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1.5rem;
            margin: 1rem;
            border-radius: 16px;
        }
        
        h1 {
            font-size: 1.8rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 1rem;
        }
    }

    /* Form Group Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .mb-3 {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
        animation-delay: calc(var(--order) * 0.1s);
    }
</style>

<script>
    // Add animation delays
    document.addEventListener('DOMContentLoaded', function() {
        const formGroups = document.querySelectorAll('.mb-3');
        formGroups.forEach((group, index) => {
            group.style.setProperty('--order', index);
        });
        
        // Add focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            const parent = input.closest('.mb-3');
            if (!parent) return;
            
            input.addEventListener('focus', () => {
                parent.classList.add('focused');
            });
            
            input.addEventListener('blur', () => {
                if (!input.value) parent.classList.remove('focused');
            });
        });
    });
</script>
<div class="container-fluid">
    <h1 class="mb-4">Edit Event</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali inputan Anda:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Proker Selection -->
        <div class="mb-3">
            <label>Proker</label>
            <select name="proker_id" class="form-control" required>
                <option value="">-- Pilih Proker --</option>
                @foreach($prokers as $proker)
                    <option value="{{ $proker->id }}" {{ $event->proker_id == $proker->id ? 'selected' : '' }}>
                        {{ $proker->subject }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Proposal Selection (Optional) -->
        <div class="mb-3">
            <label>Proposal (Opsional)</label>
            <select name="proposal_id" class="form-control">
                <option value="">-- Pilih Proposal --</option>
                @foreach($proposals as $proposal)
                    <option value="{{ $proposal->id }}" {{ $event->proposal_id == $proposal->id ? 'selected' : '' }}>
                        {{ $proposal->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Event Name -->
        <div class="mb-3">
            <label>Nama Event</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description', $event->description) }}</textarea>
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}" required>
        </div>

        <!-- Start Date -->
        <div class="mb-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required>
        </div>

        <!-- End Date -->
        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach(['draft', 'scheduled', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" {{ $event->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Banner Upload -->
        <div class="mb-3">
            <label>Banner (Opsional, upload untuk mengganti)</label>
            <input type="file" name="banner" class="form-control">
            @if($event->banner_path)
                <small>Banner saat ini: <a href="{{ asset('storage/' . $event->banner_path) }}" target="_blank">Lihat</a></small>
            @endif
        </div>

        <!-- Additional Notes -->
        <div class="mb-3">
            <label>Catatan (Opsional)</label>
            <textarea name="notes" class="form-control">{{ old('notes', $event->notes) }}</textarea>
        </div>

        <!-- Angkatan Target (Dropdown for Angkatan from CIS API) -->
        <div class="mb-3">
            <label for="angkatan_target" class="form-label">Pilih Angkatan Target</label>
            <select name="angkatan_target" id="angkatan_target" class="form-control">
                <option value="">-- Pilih Angkatan --</option>
                @foreach($angkatans as $angkatan)
                    <option value="{{ $angkatan }}" {{ $event->angkatan_target == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Update Event
        </button>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@endsection

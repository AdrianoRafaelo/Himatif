@extends('layouts.main')

@section('title', 'Galeri')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Galeri</h2>
    <div class="row">
        @foreach($galeris as $galeri)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="gallery-item position-relative overflow-hidden" style="height: 200px;">
                <img src="{{ asset('uploads/galeri/' . $galeri->gambar) }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white text-center" style="background: rgba(0,0,0,0.6); opacity: 0; transition: 0.3s;">
                    <h5 class="mb-1">{{ $galeri->judul }}</h5>
                    <small>{{ $galeri->deskripsi }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Tambahkan langsung CSS di sini jika @push tidak jalan --}}
<style>
    .gallery-item:hover .overlay {
        opacity: 1 !important;
    }

    .gallery-item img {
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }
</style>
@endsection

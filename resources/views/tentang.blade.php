@extends('layouts.main')

@section('title', 'Tentang Kami - Organisasi HMIF')

@section('content')

<style>
    /* ===== MODERN PROFESSIONAL CONTENT STYLE ===== */
    /* Base Styles */
    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.8;
        color: #333;
        background-color: #f9fafb;
    }

    .content-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Konten Styling - Scoped specifically to content */
    .content-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .content-card h1, 
    .content-card h2, 
    .content-card h3 {
        color: #2c3e50;
        margin-top: 1.5em;
        margin-bottom: 0.8em;
        font-weight: 600;
    }

    .content-card h1 {
        font-size: 2.2rem;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }

    .content-card h2 {
        font-size: 1.8rem;
        color: #2980b9;
    }

    .content-card h3 {
        font-size: 1.4rem;
        color: #16a085;
    }

    .content-card p {
        margin-bottom: 1.5em;
        font-size: 1.1rem;
        color: #555;
    }

    .content-card ul, 
    .content-card ol {
        margin-bottom: 1.5em;
        padding-left: 2em;
    }

    .content-card li {
        margin-bottom: 0.5em;
    }

    .content-card a {
        color: #3498db;
        text-decoration: none;
        transition: color 0.3s;
    }

    .content-card a:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .content-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .content-card blockquote {
        border-left: 4px solid #3498db;
        background: #f8f9fa;
        padding: 20px;
        margin: 20px 0;
        font-style: italic;
        color: #555;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-card {
            padding: 25px;
        }
        
        .content-card h1 {
            font-size: 1.8rem;
        }
    }
</style>

<div class="content-container">
    @foreach ($data as $item)
        <div class="content-card">
            {!! $item->konten !!}
        </div>
    @endforeach
</div>

@endsection
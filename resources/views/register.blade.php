@extends('layouts.main')

@section('title', 'Registrasi Event')

@section('content')
<style>
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>
<div class="container mt-5">
    <h2>Daftar ke Event: {{ $event->name }}</h2>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('student.register.store', ['eventId' => $event->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <p>Apakah Anda yakin ingin mendaftar ke event ini?</p>
        <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
    </form>
</div>
@endsection

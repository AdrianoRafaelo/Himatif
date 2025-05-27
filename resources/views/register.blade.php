@extends('layouts.main')

@section('title', 'Registrasi Event')

@section('content')
<div class="container">
    <h2>Daftar ke Event: {{ $event->nama_event }}</h2>

    <form action="{{ route('event.register.store', ['eventId' => $event->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <p>Apakah Anda yakin ingin mendaftar ke event ini?</p>
        <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
    </form>
</div>
@endsection
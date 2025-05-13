@extends('layouts.main')

@section('title', 'Registrasi Event')

@section('content')
<div class="container mt-5">
    <h2>Registrasi untuk Event: {{ $event->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.register.store') }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
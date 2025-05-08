@extends('admin.layouts')

@section('title', 'Lihat Visi Misi')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Lihat Visi Misi</h1>

    <div class="bg-white p-4 rounded shadow">
        {!! $tentang->konten !!}
    </div>

    <a href="{{ route('admin.tentang.index') }}" class="mt-4 inline-block bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
        Kembali
    </a>
@endsection

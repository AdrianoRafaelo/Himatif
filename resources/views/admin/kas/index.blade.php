@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Mahasiswa Aktif - DIII Teknologi Informasi</h1>

        <table class="min-w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2 text-left">NIM</th>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">Prodi</th>
                    <th class="border px-4 py-2 text-left">Angkatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswaList as $mhs)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $mhs['nim'] }}</td>
                        <td class="border px-4 py-2">{{ $mhs['nama'] }}</td>
                        <td class="border px-4 py-2">{{ $mhs['prodi_name'] }}</td>
                        <td class="border px-4 py-2">{{ $mhs['angkatan'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Tidak ada data mahasiswa ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

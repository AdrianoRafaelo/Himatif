@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Mahasiswa Aktif - DIII Teknologi Informasi</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Tab untuk setiap angkatan -->
        <div class="mb-4">
            <div class="flex space-x-2 border-b">
                @if(isset($angkatanList) && !empty($angkatanList))
                    @foreach($angkatanList as $angkatanItem)
                        <a href="{{ route('admin.kas.index', ['angkatan' => $angkatanItem]) }}"
                           class="px-4 py-2 {{ $angkatan == $angkatanItem ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600' }}">
                            Angkatan {{ $angkatanItem }}
                        </a>
                    @endforeach
                @else
                    <p class="text-gray-600">Tidak ada angkatan tersedia.</p>
                @endif
            </div>
        </div>

        <!-- Tampilkan data untuk angkatan yang dipilih -->
        @if($angkatan)
            <h2 class="text-xl font-semibold mb-4">Angkatan {{ $angkatan }} (Total: {{ count($mahasiswa) }} Mahasiswa)</h2>
            <form action="{{ route('admin.kas.store') }}" method="POST">
                @csrf
                <table class="min-w-full border text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">NIM</th>
                            <th class="border px-4 py-2 text-left">Nama</th>
                            <th class="border px-4 py-2 text-left">Prodi</th>
                            <th class="border px-4 py-2 text-left">Angkatan</th>
                            <th class="border px-4 py-2 text-left">Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $mhs)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-4 py-2">{{ $mhs['nim'] }}</td>
                                <td class="border px-4 py-2">{{ $mhs['nama'] }}</td>
                                <td class="border px-4 py-2">{{ $mhs['prodi_name'] }}</td>
                                <td class="border px-4 py-2">{{ $mhs['angkatan'] }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <input type="checkbox" name="bayar[{{ $mhs['nim'] }}][bayar]" value="1"
                                           {{ in_array($mhs['nim'], $payments) ? 'checked' : '' }}>
                                    <input type="hidden" name="bayar[{{ $mhs['nim'] }}][nama]" value="{{ $mhs['nama'] }}">
                                    <input type="hidden" name="bayar[{{ $mhs['nim'] }}][angkatan]" value="{{ $mhs['angkatan'] }}">
                                    <input type="hidden" name="bayar[{{ $mhs['nim'] }}][prodi]" value="{{ $mhs['prodi_name'] }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Tidak ada data mahasiswa ditemukan untuk angkatan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Tombol Submit -->
                @if(count($mahasiswa) > 0)
                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Simpan Pembayaran
                        </button>
                    </div>
                @endif
            </form>
        @else
            <p class="text-gray-600">Silakan pilih angkatan untuk melihat data mahasiswa.</p>
        @endif
    </div>
@endsection
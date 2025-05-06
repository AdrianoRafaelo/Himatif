@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Base Styles with Gradient Background */
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Header Styles with Gradient Text */
    h1 {
        font-size: 2.25rem;
        font-weight: 800;
        background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e0e7ff;
    }

    h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 1.5rem;
        position: relative;
        padding-left: 1rem;
    }

    h2::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, #3b82f6, #6366f1);
        border-radius: 4px;
    }

    /* Alert Messages with Icons */
    .alert {
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 0.75rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-left: 4px solid;
    }

    .alert-success {
        background-color: #f0fdf4;
        border-color: #34d399;
        color: #065f46;
    }

    .alert-warning {
        background-color: #fffbeb;
        border-color: #fbbf24;
        color: #92400e;
    }

    .alert-error {
        background-color: #fef2f2;
        border-color: #f87171;
        color: #b91c1c;
    }

    /* Filter Form with Glass Morphism Effect */
    .filter-form {
        display: flex;
        gap: 1.5rem;
        align-items: flex-end;
        flex-wrap: wrap;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.18);
        margin-bottom: 2.5rem;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        background-color: white;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        outline: none;
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
    }

    /* Vibrant Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    /* Tampilkan Button - Green Gradient */
    .btn-show {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .btn-show:hover {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
    }

    /* Simpan Pembayaran Button - Blue/Purple Gradient */
    .btn-save {
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        color: white;
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    /* Active/Pressed State */
    .btn:active {
        transform: translateY(0);
    }

    /* Shine Effect on Hover */
    .btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            rgba(255,255,255,0) 0%, 
            rgba(255,255,255,0.2) 50%, 
            rgba(255,255,255,0) 100%);
        transition: left 0.6s ease;
    }

    .btn:hover::after {
        left: 100%;
    }

    /* Icon Additions (optional) */
    .btn-show::before {
        content: '👁️';
        margin-right: 8px;
    }

    .btn-save::before {
        content: '💾';
        margin-right: 8px;
    }

    /* Larger Size for Save Button */
    .btn-save {
        padding: 0.875rem 2rem;
        font-size: 1rem;
    }

    /* Pulse Animation for Important Actions */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .btn-save {
        animation: pulse 2s infinite;
    }

    .btn-save:hover {
        animation: none;
    }

    /* Tab Navigation with Pill Style */
    .tab-nav {
        display: flex;
        background: #f1f5f9;
        border-radius: 0.75rem;
        padding: 0.25rem;
        margin-bottom: 2rem;
    }

    .tab-link {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        margin-right: 0.25rem;
    }

    .tab-link:hover {
        color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
    }

    .tab-link.active {
        color: white;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
    }

    /* Table Styles with Hover Effects */
    .table-container {
        overflow-x: auto;
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .table-container:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }

    thead {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }

    th {
        padding: 1.25rem;
        text-align: left;
        font-weight: 700;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background-color: #f8fafc;
    }

    /* Enhanced Checkbox Styling */
    .checkbox-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .checkbox-input {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .checkbox-input:checked {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-color: transparent;
    }

    .checkbox-input:checked::after {
        content: "✓";
        position: absolute;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Submit Button Container with Floating Effect */
    .submit-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .submit-container .btn {
        padding: 0.875rem 2rem;
        font-size: 1rem;
        border-radius: 1rem;
    }

    /* Empty State with Illustration */
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 1.5rem;
        font-size: 1.125rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
            padding: 1.5rem;
        }

        .form-group {
            min-width: 100%;
        }

        .tab-nav {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }

        .tab-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-link {
            white-space: nowrap;
        }

        th, td {
            padding: 1rem 0.75rem;
        }
    }

    /* Animation Effects */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .table-container, .filter-form, .alert {
        animation: fadeIn 0.4s ease-out forwards;
    }

    .btn-primary {
        animation: pulse 2s infinite;
    }

    .btn-primary:hover {
        animation: none;
    }
</style>

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

        @if (session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                <p>{{ session('warning') }}</p>
            </div>
        @endif

        <!-- Pemilihan Bulan dan Tahun -->
        <div class="mb-6">
            <form action="{{ route('admin.kas.index') }}" method="GET" class="filter-form flex items-center space-x-4">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
                    <select name="bulan" id="bulan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                            <option value="{{ $index + 1 }}" {{ request('bulan') == ($index + 1) ? 'selected' : '' }}>{{ $bulan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Pilih Tahun</label>
                    <select name="tahun" id="tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">-- Pilih Tahun --</option>
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear, $currentYear - 2);
                        @endphp
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                <button type="submit" class="btn btn-show">
    Tampilkan
</button>
                </div>
            </form>
        </div>

        <!-- Tab untuk setiap angkatan -->
        @if (request('bulan') && request('tahun'))
            <div class="mb-4">
                <div class="flex space-x-2 border-b">
                    @if(isset($angkatanList) && !empty($angkatanList))
                        @foreach($angkatanList as $angkatanItem)
                            <a href="{{ route('admin.kas.index', ['angkatan' => $angkatanItem, 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                               class="px-4 py-2 {{ $angkatan == $angkatanItem ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600' }}">
                                Angkatan {{ $angkatanItem }}
                            </a>
                        @endforeach
                    @else
                        <p class="text-gray-600">Tidak ada angkatan tersedia.</p>
                    @endif
                </div>
            </div>

            <!-- Tampilkan data untuk angkatan dan bulan yang dipilih -->
            @if($angkatan)
                <h2 class="text-xl font-semibold mb-4">Angkatan {{ $angkatan }} - {{ $namaBulan }} {{ $tahun }} (Total: {{ count($mahasiswa) }} Mahasiswa)</h2>
                <form action="{{ route('admin.kas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
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
                        <button type="submit" class="btn btn-save">
    Simpan Pembayaran
</button>
                        </div>
                    @endif
                </form>
            @else
                <p class="text-gray-600">Silakan pilih angkatan untuk melihat data mahasiswa.</p>
            @endif
        @else
            <p class="text-gray-600">Silakan pilih bulan dan tahun untuk melihat data pembayaran.</p>
        @endif
    </div>
@endsection
    @extends('admin.layouts')

    @section('title', 'Daftar Visi Misi')

    @section('content')
    <style>
        /* Basic reset and font settings */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
    
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    
        th, td {
            padding: 0.75rem;
            text-align: left;
            vertical-align: top;
        }
    
        th {
            background-color: #edf2f7;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #4a5568;
        }
    
        tr:nth-child(even) {
            background-color: #f7fafc;
        }
    
        tr:hover {
            background-color: #ebf8ff;
        }
    
        /* Button styling */
        .bg-green-500 {
            background-color: #48bb78;
        }
    
        .bg-green-500:hover {
            background-color: #38a169;
        }
    
        .text-white {
            color: white;
        }
    
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    
        .rounded {
            border-radius: 0.25rem;
        }
    
        .inline-block {
            display: inline-block;
        }
    
        /* Link styling */
        a {
            text-decoration: none;
            transition: color 0.2s ease;
        }
    
        .text-blue-500 {
            color: #4299e1;
        }
    
        .text-blue-500:hover {
            color: #3182ce;
        }
    
        .text-yellow-500 {
            color: #ecc94b;
        }
    
        .text-yellow-500:hover {
            color: #d69e2e;
        }
    
        /* Heading styling */
        .text-2xl {
            font-size: 1.5rem;
        }
    
        .font-bold {
            font-weight: 700;
        }
    
        .mb-4 {
            margin-bottom: 1rem;
        }
    
        /* Border styling */
        .border {
            border: 1px solid #e2e8f0;
        }
    
        /* Utility classes */
        .w-full {
            width: 100%;
        }
    
        /* No data message */
        p {
            color: #718096;
            font-style: italic;
        }
    </style>
        <h1 class="text-2xl font-bold mb-4">Daftar Visi Misi</h1>

        <a href="{{ route('admin.tentang.create') }}" class="mb-4 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            Tambah Visi Misi
        </a>

        @if($data->count())
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Konten</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{!! Str::limit(strip_tags($item->konten), 100) !!}</td>
                            <td class="p-2 border">
                                <a href="{{ route('admin.tentang.show', $item->id) }}" class="text-blue-500 hover:underline">Lihat</a> |
                                <a href="{{ route('admin.tentang.edit', $item->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data visi misi.</p>
        @endif
    @endsection

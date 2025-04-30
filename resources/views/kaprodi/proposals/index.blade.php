@extends('admin.layouts')

@section('title', 'Proposal')

@section('content')
<style>
    /* Main Container */
    .p-4 {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Title */
    .text-xl {
        font-size: 1.5rem;
        color: #1a202c;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    /* Table Styles */
    .table-auto {
        width: 100%;
        border-collapse: collapse;
    }

    .border {
        border: 1px solid #e2e8f0;
    }

    /* Table Header */
    .bg-gray-100 {
        background-color: #f7fafc;
    }

    th {
        font-weight: 600;
        text-align: left;
        color: #4a5568;
    }

    /* Table Cells */
    .px-3 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    /* Status Colors */
    .text-green-600 {
        color: #38a169;
    }

    .text-red-600 {
        color: #e53e3e;
    }

    .text-yellow-600 {
        color: #d69e2e;
    }

    .font-semibold {
        font-weight: 600;
    }

    /* Action Buttons */
    .space-x-2 > * + * {
        margin-left: 0.75rem;
    }

    button[type="submit"] {
        border: none;
        padding: 0.5rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 80px;
    }

    .bg-green-500 {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .bg-green-500:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        box-shadow: 0 4px 6px rgba(72, 187, 120, 0.3);
        transform: translateY(-1px);
    }

    .bg-green-500:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .bg-red-500 {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    .bg-red-500:hover {
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        box-shadow: 0 4px 6px rgba(245, 101, 101, 0.3);
        transform: translateY(-1px);
    }

    .bg-red-500:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Disabled State */
    .text-gray-500 {
        color: #a0aec0;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        display: inline-block;
    }

    /* Button Icons */
    button[type="submit"]::before {
        content: "";
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 6px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        filter: brightness(0) invert(1);
    }

    .bg-green-500::before {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
    }

    .bg-red-500::before {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z'/%3E%3C/svg%3E");
    }

    /* Button Group Container */
    .space-x-2 {
        display: flex;
        align-items: center;
    }

    /* Responsive Adjustments */
    @media (max-width: 640px) {
        button[type="submit"] {
            padding: 0.5rem 1rem;
            min-width: 70px;
        }
        
        button[type="submit"]::before {
            width: 14px;
            height: 14px;
            margin-right: 4px;
        }
    }

    /* Empty State */
    .text-center {
        text-align: center;
    }

    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .text-gray-500 {
        color: #a0aec0;
    }

    .italic {
        font-style: italic;
    }

    /* Zebra Striping */
    tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    tbody tr:hover {
        background-color: #ebf8ff;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .p-4 {
            padding: 1rem;
        }

        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Proposal Masuk</h1>

    <table class="w-full table-auto border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-3 py-2">Proker</th>
                <th class="border px-3 py-2">Judul</th>
                <th class="border px-3 py-2">Deskripsi</th>
                <th class="border px-3 py-2">File</th>
                <th class="border px-3 py-2">Status</th>
                <th class="border px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proposals as $proposal)
                <tr>
                    <td class="border px-3 py-2">{{ $proposal->proker->subject }}</td>
                    <td class="border px-3 py-2">{{ $proposal->title }}</td>
                    <td class="border px-3 py-2">{{ Str::limit($proposal->description, 50) }}</td>
                    <td class="border px-3 py-2">
                        <a href="{{ asset('storage/' . $proposal->file_path) }}" class="text-blue-500 underline" target="_blank">Lihat</a>
                    </td>
                    <td class="border px-3 py-2">
                        @if($proposal->status === 'approved')
                            <span class="text-green-600 font-semibold">Disetujui</span>
                        @elseif($proposal->status === 'rejected')
                            <span class="text-red-600 font-semibold">Ditolak</span>
                        @else
                            <span class="text-yellow-600 font-semibold">Menunggu</span>
                        @endif
                    </td>
                    <td class="border px-3 py-2 space-x-2">
                        @if($proposal->status === 'pending')
                            <form action="{{ route('admin.kaprodi.proposals.approve', $proposal) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Setujui</button>
                            </form>
                            <form action="{{ route('admin.kaprodi.proposals.reject', $proposal) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Tolak</button>
                            </form>
                        @else
                            <span class="text-gray-500 italic">Sudah diperiksa</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada proposal masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

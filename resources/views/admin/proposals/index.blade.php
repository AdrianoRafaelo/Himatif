@extends('admin.layouts')

@section('title', 'Status Proposal')

@section('content')
<style>
    /* Main Container */
    .p-4 {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Title */
    .text-xl {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f3f4f6;
    }

    /* Table Styles */
    .w-full {
        width: 100%;
    }

    .table-auto {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .border {
        border: 1px solid #e5e7eb;
    }

    /* Table Header */
    .bg-gray-100 {
        background-color: #f9fafb;
    }

    th {
        font-weight: 600;
        color: #374151;
        text-align: left;
        position: sticky;
        top: 0;
        background-color: #f9fafb;
    }

    /* Table Cells */
    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    /* Status Badges */
    .text-green-600 {
        color: #059669;
        background-color: #ecfdf5;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        display: inline-block;
        font-size: 0.875rem;
    }

    .text-red-600 {
        color: #dc2626;
        background-color: #fef2f2;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        display: inline-block;
        font-size: 0.875rem;
    }

    .text-yellow-600 {
        color: #d97706;
        background-color: #fef3c7;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        display: inline-block;
        font-size: 0.875rem;
    }

    .font-semibold {
        font-weight: 600;
    }

    /* File Link */
    .text-blue-600 {
        color: #2563eb;
        transition: all 0.2s ease;
    }

    .underline {
        text-decoration: none;
        border-bottom: 1px solid #93c5fd;
    }

    .text-blue-600:hover {
        color: #1d4ed8;
        border-bottom-color: #2563eb;
    }

    /* Empty State */
    .text-center {
        text-align: center;
    }

    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
        color: #6b7280;
    }

    /* Table Row Hover Effect */
    tbody tr {
        transition: background-color 0.2s ease;
    }

    tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Zebra Striping */
    tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }

    tbody tr:nth-child(even):hover {
        background-color: #f3f4f6;
    }

    /* Date Formatting */
    td:last-child {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .p-4 {
            padding: 1rem;
            overflow-x: auto;
        }

        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        th, td {
            min-width: 120px;
        }

        .text-xl {
            font-size: 1.25rem;
        }
    }
</style>

<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Status Proposal</h1>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Proker</th>
                <th class="border px-4 py-2">Judul Proposal</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">File</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Tanggal Kirim</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proposals as $index => $proposal)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $proposal->proker->subject ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $proposal->title }}</td>
                <td class="border px-4 py-2">{{ Str::limit($proposal->description, 50) }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ asset('storage/' . $proposal->file) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
                </td>
                <td class="border px-4 py-2">
                @if($proposal->status === 'approved')
                    <span class="text-green-600 font-semibold">Disetujui</span>
                @elseif($proposal->status === 'rejected')
                    <span class="text-red-600 font-semibold">Ditolak</span>
                @else
                    <span class="text-yellow-600 font-semibold">Menunggu</span>
                @endif

                </td>
                <td class="border px-4 py-2">{{ $proposal->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">Belum ada proposal.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

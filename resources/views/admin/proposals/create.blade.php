@extends('admin.layouts')

@section('title', 'Buat Proposal')

@section('content')
<link rel="stylesheet" href="{{ asset('css/proposal.css') }}">
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Kirim Proposal</h1>
    
    <form method="POST" action="{{ route('admin.proposals.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Pilih Proker -->
        <div>
            <label for="proker_id" class="block">Pilih Proker</label>
            <select name="proker_id" id="proker_id" class="w-full border px-3 py-2 rounded" required>
                <option value="">Pilih Proker</option>
                @foreach($prokers as $proker)
                    <option value="{{ $proker->id }}">{{ $proker->subject }}</option>
                @endforeach
            </select>
            @error('proker_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Judul Proposal -->
        <div>
            <label for="title" class="block">Judul Proposal</label>
            <input type="text" name="title" id="title" class="w-full border px-3 py-2 rounded" required>
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Deskripsi Proposal -->
        <div>
            <label for="description" class="block">Deskripsi Proposal</label>
            <textarea name="description" id="description" class="w-full border px-3 py-2 rounded" rows="4"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Upload File -->
        <div>
            <label for="file" class="block">File Proposal (PDF/Word)</label>
            <input type="file" name="file" id="file" class="w-full border px-3 py-2 rounded" accept=".pdf,.doc,.docx" required>
            @error('file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Tombol Kirim Proposal -->
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kirim Proposal</button>
        </div>
    </form>
</div>
@endsection

@extends('admin.layouts')

@section('title', 'Kelola Visi Misi')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Kelola Visi Misi</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($tentang)
        <form method="POST" action="{{ route('admin.tentang.update', $tentang->id) }}">
            @method('PUT')
    @else
        <form method="POST" action="{{ route('admin.tentang.store') }}">
    @endif
        @csrf
        <textarea id="konten" name="konten" rows="10">
            {{ old('konten', $tentang->konten ?? '') }}
        </textarea>
        <br>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
@endsection

@push('scripts')
    <script src="/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#konten',
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
                     'alignleft aligncenter alignright alignjustify | ' +
                     'bullist numlist outdent indent | removeformat | help | code preview fullscreen',
            menubar: 'file edit view insert format tools table help'
        });
    </script>
@endpush

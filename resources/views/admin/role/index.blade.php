@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <div class="row">
        <!-- Form Role -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Input Role untuk User Lokal</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.role.index') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username / NIM</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="role">Pilih Role</label>
                            <select name="role" class="form-control" id="role" required>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="admin">Admin</option>
                                <option value="kaprodi">Kaprodi</option>
                                <option value="bendahara">Bendahara</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Simpan Role</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Role -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-header border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Akun </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username / NIM</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td class="text-capitalize">{{ $user->role }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data role admin, bendahara, atau kaprodi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

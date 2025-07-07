@extends('layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Pengaturan Akun</h4>
        <p class="text-muted">Kelola data pengguna</p>
    </div>

    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ route('pengaturan.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                        class="form-control" required>
                </div>

                <hr>
                <h5 class="mt-4">Ganti Password</h5>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group mt-3">
                    <label for="kode_keamanan">Kode Keamanan </label>
                    <input type="password" name="kode_keamanan" id="kode_keamanan" class="form-control" required>
                    <small class="text-muted">Masukkan kode keamanan untuk menyimpan perubahan</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

        </div>
    </div>
@endsection

@extends('layouts.admin')
@section('title', 'Edit Pengguna')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Edit Pengguna</h4>
    </div>

    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $pengguna->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ $pengguna->username }}" required>
        </div>

        <div class="mb-3">
            <label>Kelas (opsional)</label>
            <input type="text" name="kelas" class="form-control" value="{{ $pengguna->kelas }}">
        </div>

        <div class="mb-3">
            <label>Peran</label>
            <select name="peran" class="form-select" required>
                <option value="admin" {{ $pengguna->peran == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="santri" {{ $pengguna->peran == 'santri' ? 'selected' : '' }}>Santri</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Password Baru (Kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
@endsection

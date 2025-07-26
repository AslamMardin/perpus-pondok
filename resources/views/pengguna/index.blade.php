@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Daftar Pengguna</h4>
        <p class="text-white-50">Manajemen akun admin dan santri</p>
    </div>

    <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahPengguna">
        <i class="fas fa-plus me-1"></i> Tambah Pengguna
    </a>

    <form action="{{ route('pengguna.index') }}" method="GET" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau username..."
            value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search me-1"></i> Cari
        </button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Peran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->kelas ?? '-' }}</td>
                        <td>{{ ucfirst($user->peran) }}</td>
                        <td>
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <div>Tidak ada data pengguna.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="modalTambahPengguna" tabindex="-1" aria-labelledby="modalTambahPenggunaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('pengguna.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kelas (Opsional)</label>
                        <input type="text" name="kelas" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Peran</label>
                        <select name="peran" class="form-select" required>
                            <option value="">-- Pilih Peran --</option>
                            <option value="admin">Admin</option>
                            <option value="santri">Santri</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

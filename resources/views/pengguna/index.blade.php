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
    <a href="{{ route('pengguna.cetakSemua') }}" class="btn btn-warning mb-3 ms-2">
        <i class="fas fa-id-card"></i> Cetak Semua Kartu
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
                    <th>panggilan</th>
                    <th>Kelas</th>
                    <th>Peran</th>
                    <th>Cetak Kartu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->kelas ?? '-' }}</td>
                        <td>{{ ucfirst($user->peran) }}</td>
                        <td>
                            <a href="{{ route('pengguna.kartu', $user->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-id-card"></i> Cetak Kartu
                            </a>
                        </td>
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
                        <label>Panggilan</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kelas (Opsional)</label>
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="">-- Pilih Kelas --</option>

                            <!-- SMP -->
                            <optgroup label="SMP">
                                <option value="7 A SMP">7 A SMP</option>
                                <option value="7 B SMP">7 B SMP</option>
                                <option value="7 C SMP">7 C SMP</option>
                                <option value="7 D SMP">7 D SMP</option>

                                <option value="8 A SMP">8 A SMP</option>
                                <option value="8 B SMP">8 B SMP</option>
                                <option value="8 C SMP">8 C SMP</option>
                                <option value="8 D SMP">8 D SMP</option>

                                <option value="9 A SMP">9 A SMP</option>
                                <option value="9 B SMP">9 B SMP</option>
                                <option value="9 C SMP">9 C SMP</option>
                            </optgroup>

                            <!-- MTs -->
                            <optgroup label="MTs">
                                <option value="7 A MTs">7 A MTs</option>
                                <option value="7 B MTs">7 B MTs</option>
                                <option value="7 C MTs">7 C MTs</option>
                                <option value="7 D MTs">7 D MTs</option>

                                <option value="8 A MTs">8 A MTs</option>
                                <option value="8 B MTs">8 B MTs</option>
                                <option value="8 C MTs">8 C MTs</option>
                                <option value="8 D MTs">8 D MTs</option>

                                <option value="9 A MTs">9 A MTs</option>
                                <option value="9 B MTs">9 B MTs</option>
                                <option value="9 C MTs">9 C MTs</option>
                            </optgroup>

                            <!-- MA -->
                            <optgroup label="MA">
                                <option value="10 Merdeka 1 MA">10 Merdeka 1 MA</option>
                                <option value="10 Merdeka 2 MA">10 Merdeka 2 MA</option>
                                <option value="10 Merdeka 3 MA">10 Merdeka 3 MA</option>
                                <option value="10 Merdeka 4 MA">10 Merdeka 4 MA</option>

                                <option value="11 Merdeka 1 MA">11 Merdeka 1 MA</option>
                                <option value="11 Merdeka 2 MA">11 Merdeka 2 MA</option>
                                <option value="11 Merdeka 3 MA">11 Merdeka 3 MA</option>
                                <option value="11 Merdeka 4 MA">11 Merdeka 4 MA</option>

                                <option value="12 Mipa 1 MA">12 Mipa 1 MA</option>
                                <option value="12 Mipa 2 MA">12 Mipa 2 MA</option>
                                <option value="12 Mipa 3 MA">12 Mipa 3 MA</option>
                                <option value="12 Mipa 3 MA">12 Mipa 4 MA</option>
                            </optgroup>
                        </select>
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

@extends('layouts.admin')

@section('title', 'Daftar Buku')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Daftar Buku</h4>
        <p class="text-white-50">Manajemen data buku perpustakaan</p>
    </div>

    <!-- Tombol Tambah Buku -->
    <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">
        <i class="fas fa-plus me-1"></i> Tambah Buku
    </a>
    @if (request('search'))
        <div class="mb-2">
            <span class="text-muted">Hasil pencarian untuk: <strong>{{ request('search') }}</strong></span>
        </div>
    @endif
    <form action="{{ route('buku.index') }}" method="GET" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari judul, kategori, atau penulis..."
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
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Rak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $i => $book)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->kategori }}</td>
                        <td>{{ $book->rak }}</td>
                        <td>
                            <a href="{{ route('buku.edit', $book->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $book->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <div>Data buku tidak ditemukan.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>


    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="modalTambahBuku" tabindex="-1" aria-labelledby="modalTambahBukuLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('buku.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahBukuLabel">Tambah Buku Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Judul Buku</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Buku</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Formal">Formal (Pelajaran Sekolah)</option>
                                <option value="Novel">Novel</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Agama">Agama (Kitab, Fikih, Tauhid)</option>
                                <option value="Bahasa">Bahasa (Arab, Inggris, Indonesia)</option>
                                <option value="Motivasi">Motivasi & Pengembangan Diri</option>
                                <option value="Biografi">Biografi Tokoh Islam</option>
                                <option value="Referensi">Referensi (Kamus, Ensiklopedia)</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="rak" class="form-label">Rak Buku</label>
                            <select name="rak" id="rak" class="form-select" required>
                                <option value="">-- Pilih Rak --</option>
                                <option value="A1">A1 - Agama Dasar</option>
                                <option value="A2">A2 - Kitab Kuning</option>
                                <option value="B1">B1 - Bahasa Arab</option>
                                <option value="B2">B2 - Bahasa Inggris</option>
                                <option value="F1">F1 - Formal Pelajaran</option>
                                <option value="N1">N1 - Novel Islami</option>
                                <option value="R1">R1 - Referensi (Kamus, Ensiklopedia)</option>
                                <option value="S1">S1 - Sejarah & Biografi</option>
                                <option value="dll">Lain-Lain</option>
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
    </div>
@endsection

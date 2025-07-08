@extends('layouts.admin')
@section('title', 'Edit Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Edit Data Peminjaman</h4>
    </div>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label>Santri</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Santri --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        {{ old('user_id', $peminjaman->user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Buku</label>
            <select name="book_id" class="form-select" required>
                <option value="">-- Pilih Buku --</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}"
                        {{ old('book_id', $peminjaman->book_id ?? '') == $book->id ? 'selected' : '' }}>
                        {{ $book->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Buku</label>
            <input type="number" name="jumlah_buku" class="form-control" min="1"
                value="{{ old('jumlah_buku', $peminjaman->jumlah_buku ?? 1) }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control"
                value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? '') }}" required>
        </div>

        {{-- Field Baru: Tanggal Tenggat (Perpanjangan) --}}
        <div class="mb-3">
            <label>Tanggal Tenggat</label>
            <input type="date" name="tanggal_tenggat" class="form-control"
                value="{{ old('tanggal_tenggat', $peminjaman->tanggal_tenggat ?? '') }}" required>
        </div>


        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="dipinjam" {{ old('status', $peminjaman->status ?? '') == 'dipinjam' ? 'selected' : '' }}>
                    Dipinjam</option>
                <option value="dikembalikan"
                    {{ old('status', $peminjaman->status ?? '') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@extends('layouts.admin')
@section('title', 'Verifikasi Pengembalian')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Verifikasi Pengembalian Buku</h4>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Detail Peminjaman</h5>

            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Santri:</strong> {{ $peminjaman->user->nama }}</li>
                <li class="list-group-item"><strong>Buku:</strong> {{ $peminjaman->book->judul }}</li>
                <li class="list-group-item"><strong>Jumlah:</strong> {{ $peminjaman->jumlah_buku }}</li>
                <li class="list-group-item"><strong>Tanggal Pinjam:</strong>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }}</li>
                <li class="list-group-item"><strong>Tanggal Tenggat:</strong>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_tenggat)->translatedFormat('d M Y') }}</li>
            </ul>

            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Hidden untuk ubah status menjadi dikembalikan --}}
                <input type="hidden" name="status" value="dikembalikan">
                <input type="hidden" name="tanggal_kembali" value="{{ now()->toDateString() }}">

                <div class="alert alert-info">
                    Pastikan buku telah diterima sebelum menekan tombol verifikasi.
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Konfirmasi Dikembalikan
                </button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

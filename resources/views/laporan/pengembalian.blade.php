@extends('layouts.admin')
@section('title', 'Laporan Pengembalian')
@section('content')
    <div class="page-header">
        <h4 class="mb-0">Laporan Pengembalian Buku</h4>
        <p class="text-muted">Daftar semua buku yang telah dikembalikan.</p>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Santri</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $i => $loan)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $loan->user->nama }}</td>
                            <td>{{ $loan->book->judul }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_kembali }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

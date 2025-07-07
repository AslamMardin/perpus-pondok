@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Laporan Peminjaman Buku</h4>
        <p class="text-muted">Filter berdasarkan rentang tanggal</p>
    </div>

    <form action="{{ route('laporan.filter') }}" method="POST" class="row g-3 mb-4">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $tanggal_mulai ?? '') }}"
                class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $tanggal_selesai ?? '') }}"
                class="form-control" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan Laporan</button>
        </div>
    </form>

    @if (isset($data))
        <div class="card">
            <div class="card-body table-responsive">
                <h5 class="mb-3">Hasil Laporan</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Santri</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $loan)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $loan->user->nama }}</td>
                                <td>{{ $loan->book->judul }}</td>
                                <td>{{ $loan->tanggal_pinjam }}</td>
                                <td>{{ $loan->tanggal_kembali ?? '-' }}</td>
                                <td>{{ ucfirst($loan->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

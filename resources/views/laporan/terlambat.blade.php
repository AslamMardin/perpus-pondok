@extends('layouts.admin')

@section('title', 'Laporan Terlambat')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Laporan Peminjaman Terlambat</h4>
        <p class="text-muted">Santri yang mengembalikan buku melewati batas waktu atau belum mengembalikan.</p>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <div class="mb-3">
                <a href="{{ route('laporan.terlambat.pdf') }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
                <a href="{{ route('laporan.terlambat.excel') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Santri</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Tenggat</th>
                        <th>Tanggal Kembali</th>
                        <th>Keterlambatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $i => $loan)
                        @php
                            $tenggat = \Carbon\Carbon::parse($loan->tanggal_tenggat);
                            $kembali = $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali) : now();
                            $terlambat = $kembali->greaterThan($tenggat) ? $tenggat->diffInDays($kembali) : 0;
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $loan->user->nama }}</td>
                            <td>{{ $loan->book->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                            <td>{{ $tenggat->translatedFormat('d F Y') }}</td>
                            <td>
                                {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td>
                                @if ($terlambat > 0)
                                    <span class="text-danger fw-bold">{{ $terlambat }} hari</span>
                                @else
                                    <span class="text-success">Tepat waktu</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $loan->status == 'dipinjam' ? 'warning' : 'success' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data keterlambatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

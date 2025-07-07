@extends('layouts.admin')

@section('title', 'Laporan Pengembalian')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Laporan Pengembalian Buku</h4>
        <p class="text-muted">Daftar seluruh pengembalian yang tercatat dalam sistem.</p>
    </div>

    {{-- Tombol Export --}}
    <div class="mb-3">
        <a href="{{ route('laporan.pengembalian.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('laporan.pengembalian.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Santri</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status Telat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $i => $loan)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $loan->user->nama }}</td>
                            <td>{{ $loan->book->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') }}</td>
                            <td>
                                @if ($loan->tanggal_kembali > $loan->tanggal_tenggat)
                                    <span class="text-danger">Terlambat</span>
                                @else
                                    <span class="text-success">Tepat Waktu</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">{{ ucfirst($loan->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

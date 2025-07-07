@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Laporan Peminjaman Buku</h4>
        <p class="text-muted">Daftar seluruh peminjaman yang tercatat dalam sistem.</p>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Santri</th>
                        <th>Judul Buku</th>
                        <th>Lama Peminjaman</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Tenggat</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $i => $loan)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $loan->user->nama }}</td>
                            <td>{{ $loan->book->judul }}</td>
                            <td>
                                @php
                                    $endDate = $loan->tanggal_kembali ?? now();
                                    $startDate = \Carbon\Carbon::parse($loan->tanggal_pinjam);
                                    $days = $startDate->diffInDays(\Carbon\Carbon::parse($endDate));
                                @endphp
                                {{ $days <= 1 ? 'Sehari' : $days . ' hari' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->tanggal_tenggat)->translatedFormat('d F Y') }}</td>
                            <td>
                                {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') : '-' }}
                            </td>

                            <td>
                                <span class="badge bg-{{ $loan->status == 'dipinjam' ? 'warning' : 'success' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

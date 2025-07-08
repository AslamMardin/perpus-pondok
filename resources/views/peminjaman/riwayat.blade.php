@extends('layouts.admin')

@section('title', 'Riwayat Pengembalian')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Riwayat Pengembalian Buku</h4>
        <p class="text-muted">Data pengembalian buku oleh santri</p>
    </div>

    {{-- Filter berdasarkan kelas --}}
    <form method="GET" class="mb-3 row g-2">
        {{-- Filter Tanggal --}}
        <form method="GET" class="mb-3 row g-2">
            <div class="col-md-4">
                <label for="tanggal" class="form-label">Filter Tanggal</label>
                <select name="tanggal" id="tanggal" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="terlambat" {{ request('tanggal') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
        </form>


    </form>


    {{-- Tabel riwayat pengembalian --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Santri</th>
                    <th>Kelas</th>
                    <th>Judul Buku</th>
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
                        <td>{{ $loan->user->kelas }}</td>
                        <td>{{ $loan->book->judul }}</td>

                        {{-- Tanggal Pinjam --}}
                        <td>
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('j F Y') }}
                            @if (\Carbon\Carbon::parse($loan->tanggal_pinjam)->isToday())
                                <span class="badge bg-info text-dark ms-1">Hari Ini</span>
                            @endif
                        </td>

                        {{-- Tanggal Tenggat --}}
                        <td>
                            {{ \Carbon\Carbon::parse($loan->tanggal_tenggat)->translatedFormat('j F Y') }}
                        </td>

                        {{-- Tanggal Kembali --}}
                        <td>
                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('j F Y') }}
                        </td>

                        {{-- Status --}}
                        <td>
                            @if ($loan->tanggal_kembali > $loan->tanggal_tenggat)
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-success">Tepat Waktu</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                            Tidak ada data pengembalian buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $loans->withQueryString()->links() }}
        </div>
    </div>

@endsection

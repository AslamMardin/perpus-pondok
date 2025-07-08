@extends('layouts.admin')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Daftar Peminjaman</h4>
        <p class="text-white-50">Manajemen peminjaman buku oleh santri</p>
    </div>

    {{-- Filter, Pencarian, dan Tombol Catat --}}
    <div class="row mb-3 align-items-center g-2">
        {{-- Form Filter dan Search --}}
        <div class="col-md-9">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="d-flex flex-wrap align-items-center gap-2">
                {{-- Dropdown Filter --}}
                <select name="filter" class="form-select w-auto">
                    <option value="">-- Semua Status --</option>
                    <option value="dipinjam" {{ request('filter') == 'dipinjam' ? 'selected' : '' }}>📅 Dipinjam</option>
                    <option value="dikembalikan" {{ request('filter') == 'dikembalikan' ? 'selected' : '' }}>📅 Dikembalikan
                    </option>
                    <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>📅 Pinjam Hari Ini
                    </option>
                </select>

                {{-- Input Pencarian --}}
                <input type="text" name="search" class="form-control w-auto" placeholder="Cari santri atau buku..."
                    value="{{ request('search') }}">

                {{-- Tombol Submit --}}
                <button type="submit" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </form>
        </div>

        {{-- Tombol Catat --}}
        <div class="col-md-3 text-md-end">
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary w-100 w-md-auto">
                <i class="fas fa-plus me-1"></i> Catat Peminjaman
            </a>
        </div>
    </div>


    {{-- Tabel --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Santri</th>
                                <th>Buku</th>
                                <th>Jumlah Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Watu</th>
                                <th>Tanggal Kembali</th>
                                <th>Status Telat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loans as $i => $loan)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $loan->user->nama }}</td>
                                    <td>{{ $loan->book->judul }}</td>
                                    <td>{{ $loan->jumlah_buku }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d M Y') }}
                                        @if (\Carbon\Carbon::parse($loan->tanggal_pinjam)->isToday())
                                            <span class="badge bg-info text-dark ms-1">Pinjam Hari Ini</span>
                                        @endif
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_tenggat)->translatedFormat('d M Y') }}</td>

                                    <td>
                                        @if ($loan->tanggal_kembali)
                                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $isTerlambat = false;

                                            $tenggat = \Carbon\Carbon::parse($loan->tanggal_tenggat)->toDateString(); // hanya tanggal
                                            $tanggalKembali = $loan->tanggal_kembali
                                                ? \Carbon\Carbon::parse($loan->tanggal_kembali)->toDateString()
                                                : null;
                                            $hariIni = now()->toDateString();

                                            if ($loan->status === 'dipinjam' && $hariIni > $tenggat) {
                                                $isTerlambat = true;
                                            } elseif ($loan->status === 'dikembalikan' && $tanggalKembali > $tenggat) {
                                                $isTerlambat = true;
                                            }
                                        @endphp

                                        @if ($isTerlambat)
                                            <span class="badge bg-danger">Terlambat</span>
                                        @elseif ($loan->status === 'dipinjam')
                                            <span class="badge bg-warning text-dark">Belum Kembali</span>
                                        @else
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        @endif

                                    </td>



                                    <td>
                                        <span
                                            class="badge bg-{{ $loan->status == 'dikembalikan' ? 'success' : 'warning' }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('peminjaman.edit', $loan->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('peminjaman.destroy', $loan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <i class="fas fa-book-reader fa-2x mb-2"></i>
                                        <div>Belum ada data peminjaman.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $loans->withQueryString()->links() }}
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush

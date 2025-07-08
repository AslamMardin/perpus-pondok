@extends('layouts.admin')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Daftar Peminjaman</h4>
        <p class="text-white-50">Manajemen peminjaman buku oleh santri</p>
    </div>

    {{-- Filter dan Tombol Catat --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        {{-- Form Filter --}}
        <form method="GET" action="{{ route('peminjaman.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
            <select name="filter" class="form-select w-auto">
                <option value="">-- Semua Status --</option>
                <option value="dipinjam" {{ request('filter') == 'dipinjam' ? 'selected' : '' }}>📅 Dipinjam</option>
                <option value="dikembalikan" {{ request('filter') == 'dikembalikan' ? 'selected' : '' }}>📅 Dikembalikan
                </option>
                <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>📅 Pinjam Hari Ini</option>
            </select>
            <button type="submit" class="btn btn-outline-success btn-sm">Filter</button>
        </form>


        {{-- Tombol Catat --}}
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Catat Peminjaman
        </a>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Santri</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Batas</th>
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
                            @if ($loan->tanggal_kembali && $loan->tanggal_kembali > $loan->tanggal_tenggat)
                                <span class="badge bg-danger">Terlambat</span>
                            @elseif ($loan->status == 'dipinjam' && $loan->tanggal_tenggat && now()->gt($loan->tanggal_tenggat))
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-success">Tepat Waktu</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $loan->status == 'dikembalikan' ? 'success' : 'warning' }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.edit', $loan->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('peminjaman.destroy', $loan->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
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
@endsection

@push('scripts')
@endpush

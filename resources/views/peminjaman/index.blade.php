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
                    <table class="table table-hover table-bordered align-middle" style="min-height: 200px">
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
                                        <span
                                            class="badge bg-{{ $loan->status == 'dikembalikan' ? 'success' : 'warning' }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cog"></i> Aksi
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {{-- Verifikasi / Edit --}}
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('peminjaman.edit', $loan->id) }}">
                                                        <i class="fas fa-check-circle text-success me-2"></i> Verifikasi /
                                                        Edit
                                                    </a>
                                                </li>

                                                {{-- Hapus --}}
                                                <li>
                                                    <form action="{{ route('peminjaman.destroy', $loan->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item text-danger">
                                                            <i class="fas fa-trash-alt me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
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

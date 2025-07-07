@extends('layouts.admin')

@section('title', 'Laporan Per Santri')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Laporan Per Santri</h4>
        <p class="text-muted">Tampilkan data peminjaman berdasarkan nama santri.</p>
    </div>

    {{-- Form Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="POST" action="{{ route('laporan.santri.filter') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label">Pilih Santri</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Pilih Santri --</option>
                            @foreach ($santriList as $santri)
                                <option value="{{ $santri->id }}" {{ old('user_id') == $santri->id ? 'selected' : '' }}>
                                    {{ $santri->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    @if (!empty($loans))
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Tenggat</th>
                            <th>Tanggal Kembali</th>
                            <th>Status Telat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $i => $loan)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $loan->book->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->tanggal_tenggat)->translatedFormat('d F Y') }}</td>
                                <td>
                                    @if ($loan->tanggal_kembali)
                                        {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($loan->tanggal_kembali && $loan->tanggal_kembali > $loan->tanggal_tenggat)
                                        <span class="text-danger">Terlambat</span>
                                    @else
                                        <span class="text-success">Tepat Waktu</span>
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
                                <td colspan="7" class="text-center text-muted">Tidak ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

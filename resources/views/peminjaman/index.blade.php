@extends('layouts.admin')
@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Daftar Peminjaman</h4>
        <p class="text-white-50">Manajemen peminjaman buku oleh santri</p>
    </div>



    <!-- Form Filter dan Tombol Catat dalam 1 baris -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <!-- Form Filter -->
        <form method="GET" action="{{ route('peminjaman.index') }}" class="d-flex align-items-center gap-2">
            <select name="filter" class="form-select w-auto">
                <option value="">-- Semua Status --</option>
                <option value="terlambat" {{ request('filter') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="dipinjam" {{ request('filter') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="dikembalikan" {{ request('filter') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan
                </option>
            </select>
            <button type="submit" class="btn btn-outline-success btn-sm">Filter</button>
        </form>

        <!-- Tombol Catat Peminjaman -->
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Catat Peminjaman
        </a>
    </div>

    <div class="table-responsive">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Santri</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
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
                        <td>{{ $loan->tanggal_pinjam }}</td>
                        <td>{{ $loan->tanggal_kembali ?? '-' }}</td>
                        <td>
                            <button
                                class="btn btn-sm toggle-status 
        {{ $loan->status == 'dikembalikan' ? 'btn-success' : 'btn-warning' }}"
                                data-id="{{ $loan->id }}">
                                {{ ucfirst($loan->status) }}
                            </button>
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
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-book-reader fa-2x mb-2"></i>
                            <div>Tidak ada data peminjaman.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelectorAll('.toggle-status').forEach(button => {
            button.addEventListener('click', function() {
                const loanId = this.getAttribute('data-id');

                fetch(`/peminjaman/${loanId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(
                                1);
                            this.classList.toggle('btn-success');
                            this.classList.toggle('btn-warning');
                        } else {
                            alert('Gagal mengubah status.');
                        }
                    })
                    .catch(() => alert('Terjadi kesalahan server.'));
            });
        });
    </script>
@endpush

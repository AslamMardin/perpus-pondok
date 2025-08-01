@extends('layouts.admin')

@section('title', 'Laporan Per Santri')

@section('content')
    <div class="page-header mb-3">
        <h4 class="mb-0">Laporan Per Santri</h4>
        <p class="text-muted">Tampilkan data peminjaman berdasarkan nama santri.</p>
    </div>

    {{-- Form Filter --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('laporan.santri.filter') }}">
                @csrf
                <input type="hidden" name="user_id" id="userIdInput">

                <div class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label">Santri Terpilih</label>
                        <input type="text" class="form-control bg-light" id="santriNamaInput" placeholder="Belum dipilih"
                            readonly>
                    </div>
                    <div class="col-md-2 d-grid">
                        <label class="form-label invisible">.</label>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#modalSantri">
                            <i class="fas fa-user me-1"></i> Pilih Santri
                        </button>
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i> Tampilkan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    @if (!empty($loans))
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">Hasil Laporan Peminjaman</span>

                {{-- Tombol Export PDF --}}
                <a href="{{ route('laporan.santri.pdf', ['id' => request('user_id') ?? $userId]) }}"
                    class="btn btn-sm btn-danger" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
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
                                        <span class="text-muted">Belum Kembali</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($loan->tanggal_kembali && $loan->tanggal_kembali > $loan->tanggal_tenggat)
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-success">Tepat Waktu</span>
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

    {{-- Modal Pilih Santri --}}
    <div class="modal fade" id="modalSantri" tabindex="-1" aria-labelledby="modalSantriLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Santri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y:auto;">
                    <input type="text" id="searchSantri" class="form-control mb-3" placeholder="Cari nama santri...">
                    <ul class="list-group" id="listSantri">
                        @foreach ($santriList as $santri)
                            <li class="list-group-item list-group-item-action" data-id="{{ $santri->id }}"
                                data-nama="{{ $santri->nama }}">
                                {{ $santri->nama }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchSantri');
            const santriList = document.querySelectorAll('#listSantri li');
            const userIdInput = document.getElementById('userIdInput');
            const santriNamaInput = document.getElementById('santriNamaInput');

            // Pencarian nama
            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                santriList.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(keyword) ? '' : 'none';
                });
            });

            // Pilih santri
            santriList.forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;

                    userIdInput.value = id;
                    santriNamaInput.value = nama;

                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'modalSantri'));
                    modal.hide();
                });
            });
        });
    </script>
@endpush

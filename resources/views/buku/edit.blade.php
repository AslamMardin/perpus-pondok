@extends('layouts.admin')
@section('title', 'Edit Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Edit Peminjaman Buku</h4>
    </div>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Book ID --}}
            <div class="col-md-6 mb-3">
                <label>ID Buku</label>
                <input type="text" name="book_id" id="book_id" class="form-control" value="{{ $peminjaman->book_id }}"
                    oninput="cariBuku()" required readonly>
                <small class="text-muted">Tidak dapat mengubah ID buku</small>

                <div id="detail_buku" class="border rounded p-2 bg-light mt-2">
                    <small><strong>Judul:</strong> <span
                            id="judul_buku">{{ $peminjaman->book->judul ?? '-' }}</span></small><br>
                    <small><strong>Kategori:</strong> <span
                            id="kategori_buku">{{ $peminjaman->book->kategori ?? '-' }}</span></small><br>
                    <small><strong>Rak:</strong> <span id="rak_buku">{{ $peminjaman->book->rak ?? '-' }}</span></small>
                </div>
            </div>

            {{-- Santri --}}
            <div class="col-md-6 mb-3">
                <label>Santri</label>
                <div class="input-group">
                    <input type="hidden" name="user_id" id="user_id" value="{{ $peminjaman->user_id }}">
                    <input type="text" id="user_nama" class="form-control" value="{{ $peminjaman->user->nama ?? '' }}"
                        readonly required data-bs-toggle="modal" data-bs-target="#modalCariSantri" style="cursor: pointer;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#modalCariSantri">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Tanggal Pinjam --}}
            <div class="col-md-4 mb-3">
                <label>Tanggal Pinjam</label>
                <input type="text" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control"
                    value="{{ $peminjaman->tanggal_pinjam }}" required>
            </div>

            {{-- Tanggal Kembali --}}
            <div class="col-md-4 mb-3">
                <label>Tanggal Kembali</label>
                <input type="text" id="tanggal_kembali" name="tanggal_kembali" class="form-control"
                    value="{{ $peminjaman->tanggal_kembali }}">
            </div>

            {{-- Status --}}
            <div class="col-md-4 mb-3">
                <label>Status</label>
                <select name="status" class="form-select border-0 bg-light text-dark fw-semibold shadow-sm rounded">
                    <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>📚 Dipinjam</option>
                    <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>✅
                        Dikembalikan</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>

    {{-- Modal Cari Santri --}}
    <div class="modal fade" id="modalCariSantri" tabindex="-1" aria-labelledby="modalCariSantriLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Santri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchSantriInput"
                            placeholder="Cari nama atau kelas...">
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody id="santriTableBody">
                            @foreach ($users->where('peran', 'santri') as $user)
                                <tr>
                                    <td class="nama">{{ $user->nama }}</td>
                                    <td class="kelas">{{ $user->kelas }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary"
                                            onclick="pilihSantri('{{ $user->id }}', '{{ $user->nama }}')">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#tanggal_pinjam", {
                dateFormat: "Y-m-d",
                defaultDate: "{{ $peminjaman->tanggal_pinjam }}"
            });

            flatpickr("#tanggal_kembali", {
                dateFormat: "Y-m-d",
                defaultDate: "{{ $peminjaman->tanggal_kembali }}"
            });
        });

        function pilihSantri(id, nama) {
            document.getElementById('user_id').value = id;
            document.getElementById('user_nama').value = nama;
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalCariSantri'));
            modal.hide();
        }

        document.getElementById('searchSantriInput').addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('#santriTableBody tr');

            rows.forEach(row => {
                const nama = row.querySelector('.nama').textContent.toLowerCase();
                const kelas = row.querySelector('.kelas').textContent.toLowerCase();
                row.style.display = (nama.includes(search) || kelas.includes(search)) ? '' : 'none';
            });
        });
    </script>
@endpush

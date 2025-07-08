@extends('layouts.admin')
@section('title', 'Catat Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Catat Peminjaman Buku</h4>
    </div>

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        {{-- Row Buku & Santri --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>ID Buku (Scan/Manual)</label>
                <input type="text" name="book_id" id="book_id" class="form-control" oninput="cariBuku()" required>
                <small class="text-muted">Tekan <kbd>Ctrl</kbd> atau <kbd>Ctrl + B</kbd> untuk fokus ke sini</small>

                <div id="detail_buku" class="border rounded p-2 bg-light mt-2 d-none">
                    <small><strong>Judul:</strong> <span id="judul_buku"></span></small><br>
                    <small><strong>Kategori:</strong> <span id="kategori_buku"></span></small><br>
                    <small><strong>Rak:</strong> <span id="rak_buku"></span></small>
                </div>
                <p id="pesan_buku" class="text-danger d-none mt-1">Buku tidak ditemukan.</p>
            </div>

            <div class="col-md-6 mb-3">
                <label>Santri</label>
                <div class="input-group">
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="text" id="user_nama" class="form-control" placeholder="Klik cari santri..." readonly
                        required data-bs-toggle="modal" data-bs-target="#modalCariSantri" style="cursor: pointer;">

                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#modalCariSantri">
                        <i class="fas fa-search"></i>
                    </button>
                </div>






            </div>
        </div>

        {{-- Row Tanggal & Status --}}
        <div class="row">
            <div class="col-md-2 mb-3">
                <label>Jumlah Buku</label>
                <input type="number" name="jumlah_buku" class="form-control" min="1"
                    value="{{ old('jumlah_buku', 1) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Tanggal Pinjam</label>
                <input type="text" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Batas Pinjaman</label>
                <div class="input-group">
                    <input type="text" id="tanggal_kembali" name="tanggal_kembali" class="form-control">
                    <button type="button" class="btn btn-outline-secondary" onclick="setKembaliHariIni()">Hari Ini</button>
                </div>
            </div>


            <div class="col-md-2 mb-3">
                <label>Status</label>
                <select name="status" class="form-select border-0 bg-warning text-dark fw-semibold shadow-sm rounded">
                    <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>📚 Dipinjam</option>
                    <option value="dikembalikan" {{ old('status') == 'dikembalikan' ? 'selected' : '' }}>✅ Dikembalikan
                    </option>
                </select>
            </div>
        </div>



        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>




    <div class="modal fade" id="modalCariSantri" tabindex="-1" aria-labelledby="modalCariSantriLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Santri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Input Pencarian -->
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
                            @foreach ($santriPerKelas as $kelas => $users)
                                @foreach ($users as $user)
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
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('styles')
    <style>
        .btn-santri {
            border: 1px solid #4CAF50;
            color: #4CAF50;
            font-weight: 500;
            padding: 4px 10px;
            font-size: 0.85rem;
            border-radius: 6px;
            background-color: white;
            transition: 0.2s ease;
        }

        .btn-santri:hover,
        .btn-santri:focus {
            background-color: #4CAF50;
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Inisialisasi flatpickr untuk tanggal pinjam dan tanggal kembali
        flatpickr("#tanggal_pinjam", {
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });

        flatpickr("#tanggal_kembali", {
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });

        // Fungsi shortcut: kembalikan hari ini
        function setKembaliHariIni() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_kembali').value = today;
        }

        // Shortcut Ctrl atau Ctrl+B untuk fokus ke input ID Buku dan kosongkan nilainya
        document.addEventListener('keydown', function(e) {
            const bookInput = document.getElementById('book_id');

            // Tekan Ctrl (sendiri) ATAU Ctrl+B
            if ((e.ctrlKey && e.code === 'ControlLeft') || (e.ctrlKey && e.key.toLowerCase() === 'b')) {
                e.preventDefault();
                bookInput.focus();
                bookInput.value = ''; // Kosongkan isinya
            }
        });

        // Fungsi memilih santri dari daftar atau modal
        function pilihSantri(id, nama) {
            document.getElementById('user_id').value = id;
            document.getElementById('user_nama').value = nama;
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalCariSantri'));
            modal.hide();
        }

        // Filter santri saat mengetik di kolom pencarian modal
        document.getElementById('searchSantriInput').addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('#santriTableBody tr');
            rows.forEach(row => {
                const nama = row.querySelector('.nama').textContent.toLowerCase();
                const kelas = row.querySelector('.kelas').textContent.toLowerCase();
                row.style.display = nama.includes(search) || kelas.includes(search) ? '' : 'none';
            });
        });

        // Cari detail buku berdasarkan input ID buku
        function cariBuku() {
            const id = document.getElementById('book_id').value;
            const pesan = document.getElementById('pesan_buku');
            if (id.length > 0) {
                fetch(`/api/buku/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.judul) {
                            document.getElementById('detail_buku').classList.remove('d-none');
                            document.getElementById('judul_buku').innerText = data.judul;
                            document.getElementById('kategori_buku').innerText = data.kategori;
                            document.getElementById('rak_buku').innerText = data.rak;
                            pesan.classList.add('d-none');
                        } else {
                            document.getElementById('detail_buku').classList.add('d-none');
                            pesan.classList.remove('d-none');
                        }
                    })
                    .catch(() => {
                        document.getElementById('detail_buku').classList.add('d-none');
                        pesan.classList.remove('d-none');
                    });
            } else {
                document.getElementById('detail_buku').classList.add('d-none');
                pesan.classList.add('d-none');
            }
        }
    </script>
@endpush

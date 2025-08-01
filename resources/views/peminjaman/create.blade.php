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
                <label class="fw-semibold">ID Buku (Scan/Manual)</label>
                <input type="text" name="book_id" id="book_id" class="form-control shadow-sm" oninput="cariBuku()"
                    required>
                <small class="text-muted d-block mt-1">
                    Tekan <kbd>Ctrl</kbd> atau <kbd>Ctrl + B</kbd> untuk fokus ke sini
                </small>

                <!-- Detail Buku -->
                <div id="detail_buku" class="mt-3 d-none">
                    <div class="card border-0 shadow-sm rounded-3"
                        style="background: linear-gradient(135deg, #f0fff4, #ffffff);">
                        <div class="card-body py-2">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-success">
                                        <i class="fas fa-book me-2"></i> <span id="judul_buku"></span>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i> Rak: <span id="rak_buku"></span>
                                    </small>
                                </div>
                                <div>
                                    <span id="status_buku" class="badge bg-success">Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pesan Buku Tidak Ditemukan -->
                <p id="pesan_buku" class="text-danger fw-semibold d-none mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i> Buku tidak ditemukan.
                </p>
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
                <input type="hidden" name="status" value="dipinjam">

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
        /* Animasi Fade In */
        @keyframes fadeInDetail {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #detail_buku.animate__fadeIn {
            animation: fadeInDetail 0.3s ease-in-out;
        }

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
        function updateStatusBadge(status) {
            const badge = document.getElementById('status_buku');
            if (status === 'tersedia') {
                badge.className = 'badge bg-success';
                badge.textContent = 'Tersedia';
            } else if (status === 'dipinjam') {
                badge.className = 'badge bg-danger';
                badge.textContent = 'Dipinjam';
            } else {
                badge.className = 'badge bg-secondary';
                badge.textContent = 'Tidak Diketahui';
            }
        }

        function cariBuku() {
            const id = document.getElementById('book_id').value;
            const detail = document.getElementById('detail_buku');
            const pesan = document.getElementById('pesan_buku');

            if (id.length > 0) {
                fetch(`/api/buku/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.judul) {
                            document.getElementById('judul_buku').innerText = data.judul;
                            document.getElementById('rak_buku').innerText = data.rak.nama;
                            updateStatusBadge(data.status || 'tersedia');

                            detail.classList.remove('d-none');
                            pesan.classList.add('d-none');
                        } else {
                            detail.classList.add('d-none');
                            pesan.classList.remove('d-none');
                        }
                    })
                    .catch(() => {
                        detail.classList.add('d-none');
                        pesan.classList.remove('d-none');
                    });
            } else {
                detail.classList.add('d-none');
                pesan.classList.add('d-none');
            }
        }
    </script>
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

            // Tekan Ctrl sendiri atau Ctrl + B
            if ((e.ctrlKey && e.code === 'ControlLeft') || (e.ctrlKey && e.key.toLowerCase() === 'b')) {
                e.preventDefault();

                // Tampilkan SweetAlert dulu
                Swal.fire({
                    icon: 'info',
                    title: 'Silakan Scan',
                    text: 'Silakan scan bukunya sekarang',
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        bookInput.focus();
                        bookInput.value = '';
                    }
                });
            }
        });


        // Fungsi memilih santri dari daftar atau modal
        function pilihSantri(id, nama) {
            document.getElementById('user_id').value = id;
            document.getElementById('user_nama').value = nama;
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalCariSantri'));
            modal.hide();
            // Notifikasi toast kanan atas
            Swal.fire({
                toast: true,
                position: 'top-end', // kanan atas
                icon: 'success',
                title: `Santri dipilih: ${nama}`,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#4CAF50',
                color: 'white',
                customClass: {
                    popup: 'shadow-lg rounded-3'
                }
            });
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
                            // console.log(data)
                            document.getElementById('detail_buku').classList.remove('d-none');
                            document.getElementById('judul_buku').innerText = data.judul;
                            document.getElementById('rak_buku').innerText = data.rak.nama;
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

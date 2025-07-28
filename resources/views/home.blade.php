@extends('layouts.app')

@section('title', 'Daftar Peminjam Buku Hari Ini - PPM Al-Ikhlash Lampoko')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-person-circle me-1"></i>

            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo PPM" class="rounded-circle me-3"
                            style="width: 60px; height: 60px; object-fit: cover;">

                        <div>
                            <h4 class="mb-0 fw-bold">Daftar Peminjam Buku Hari Ini</h4>
                            <p class="mb-0 text-muted">PPM Al-Ikhlash Lampoko - {{ date('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    @if (Auth::check())
                        <!-- Jika Sudah Login -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ Auth::user()->nama ?? Auth::user()->username }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard

                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="confirmLogout()">
                                        <i class="bi bi-box-arrow-right me-2 text-danger"></i> Logout

                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Jika Belum Login -->
                        <a href="{{ route('login') }}" class="btn btn-light">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login Admin

                        </a>
                    @endif

                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 bg-light" id="searchInput"
                                        placeholder="Cari nama santri atau judul buku...">
                                    <!-- Tombol Cari Buku -->
                                    <button class="btn btn-success no-print" data-bs-toggle="modal"
                                        data-bs-target="#modalCariBuku">
                                        <i class="bi bi-search"></i> Cari Buku
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-0">{{ $loans->count() }}</h3>
                        <small class="text-muted">Peminjaman Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-journal"></i>
                            Data Peminjaman Hari Ini
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="loansTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">#</th>

                                        <th>Judul Buku</th>
                                        <th>Jumlah Buku</th>
                                        <th class="text-center">Kelas</th>
                                        <th>Nama Santri</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($loans as $i => $loan)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>

                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ $loan->book->judul }}</h6>

                                                </div>
                                            </td>
                                            <td>{{ $loan->jumlah_buku }}
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-dark">{{ $loan->user->kelas ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{{ $loan->user->nama }}</h6>
                                                <small class="text-muted">{{ $loan->user->kelas ?? '-' }}</small>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox-fill" style="font-size: 2rem;"></i><br>
                                                Tidak ada peminjaman hari ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>


                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="text-center py-4 border-top">
                    <p class="text-muted mb-0">
                        PPM Al-Ikhlash Lampoko | 2025 | Produk Aslam Mardin,S.Kom., M.Kom
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cari Buku -->
    <div class="modal fade" id="modalCariBuku" tabindex="-1" aria-labelledby="modalCariBukuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCariBukuLabel">Cari Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Input Pencarian -->
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchBuku" class="form-control border-0 bg-light"
                            placeholder="Cari judul atau rak buku...">
                    </div>

                    <!-- Tabel Hasil -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Buku</th>
                                    <th>Rak</th>
                                </tr>
                            </thead>
                            <tbody id="hasilCari">
                                @foreach ($books as $i => $book)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $book->judul }}</td>
                                        <td>{{ $book->rak->nama ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Logout',
                text: 'Yakin ingin keluar dari akun?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    <script>
        document.getElementById('searchBuku').addEventListener('keyup', function() {
            let keyword = this.value.toLowerCase();
            let rows = document.querySelectorAll('#hasilCari tr');

            rows.forEach(row => {
                let judul = row.cells[1].innerText.toLowerCase();
                let rak = row.cells[2].innerText.toLowerCase();
                row.style.display = (judul.includes(keyword) || rak.includes(keyword)) ? '' : 'none';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#loansTable tbody tr');

            searchInput.addEventListener('keyup', function() {
                const keyword = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    if (rowText.includes(keyword)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });



            // Add smooth hover effects
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                    this.style.transform = 'translateX(5px)';
                    this.style.transition = 'all 0.2s ease';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                    this.style.transform = '';
                });
            });

            // Auto-refresh every 5 minutes
            setInterval(function() {
                location.reload();
            }, 300000);
        });
    </script>
@endsection

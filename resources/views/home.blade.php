@extends('layouts.app')

@section('title', 'Daftar Peminjam Buku Hari Ini - PPM Al-Ikhlash Lampoko')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid">
        <!-- Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">
                        <i class="fas fa-book-open me-3"></i>
                        Daftar Peminjam Buku Hari Ini
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">
                        PPM Al-Ikhlash Lampoko - {{ date('d F Y') }}
                    </p>
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
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="confirmLogout()">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
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
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Login Admin
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
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 bg-light" id="searchInput"
                                        placeholder="Cari nama santri atau judul buku...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select bg-light border-0" id="statusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="dipinjam">Dipinjam</option>
                                    <option value="dikembalikan">Dikembalikan</option>
                                    <option value="terlambat">Terlambat</option>
                                </select>
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
                            <i class="fas fa-list me-2 text-primary"></i>
                            Data Peminjaman
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="loansTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">#</th>
                                        <th>Nama Santri</th>
                                        <th class="text-center">Kelas</th>
                                        <th>Judul Buku</th>
                                        <th class="text-center">Tanggal Pinjam</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($loans as $i => $loan)
                                        @php
                                            $status = 'dipinjam';
                                            if ($loan->tanggal_kembali) {
                                                $status = 'dikembalikan';
                                            } elseif (
                                                $loan->tanggal_tenggat &&
                                                strtotime($loan->tanggal_tenggat) < time()
                                            ) {
                                                $status = 'terlambat';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $loan->user->nama }}</h6>
                                                        <small class="text-muted">{{ $loan->user->username ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-light text-dark">{{ $loan->user->kelas ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ $loan->book->judul }}</h6>
                                                    <small class="text-muted">{{ $loan->book->kategori ?? '-' }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ date('d/m/Y', strtotime($loan->tanggal_pinjam)) }}
                                            </td>
                                            <td class="text-center">
                                                <span class="status-badge status-{{ $status }}">
                                                    @if ($status == 'dipinjam')
                                                        <i class="fas fa-clock me-1"></i>Dipinjam
                                                    @elseif ($status == 'dikembalikan')
                                                        <i class="fas fa-check-circle me-1"></i>Dikembalikan
                                                    @else
                                                        <i class="fas fa-exclamation-triangle me-1"></i>Terlambat
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
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
                        <i class="fas fa-mosque me-2"></i>
                        PPM Al-Ikhlash Lampoko | 2025
                    </p>
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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const table = document.getElementById('loansTable');
            const rows = table.querySelectorAll('tbody tr');

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterTable();
            });

            // Status filter functionality
            statusFilter.addEventListener('change', function() {
                filterTable();
            });

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value.toLowerCase();

                rows.forEach(row => {
                    if (row.cells.length === 1) return; // Skip empty state row

                    const santriName = row.cells[1].textContent.toLowerCase();
                    const bookTitle = row.cells[3].textContent.toLowerCase();
                    const status = row.querySelector('.status-badge').textContent.toLowerCase();

                    const matchesSearch = santriName.includes(searchTerm) || bookTitle.includes(searchTerm);
                    const matchesStatus = !statusFilter || status.includes(statusFilter);

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

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

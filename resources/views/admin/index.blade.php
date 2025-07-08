        @extends('layouts.admin')

        @section('content')
        @section('content')
            <!-- Statistics Cards + Tombol Catat -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="stats-icon"><i class="fas fa-book"></i></div>
                                </div>
                                <div class="col-auto text-end">
                                    <h5 class="mb-0">{{ $totalBooks }}</h5>
                                    <p class="text-muted mb-0">Total Buku</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="stats-icon"><i class="fas fa-users"></i></div>
                                </div>
                                <div class="col-auto text-end">
                                    <h5 class="mb-0">{{ $totalUsers }}</h5>
                                    <p class="text-muted mb-0">Pengguna</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="stats-icon"><i class="fas fa-hand-holding"></i></div>
                                </div>
                                <div class="col-auto text-end">
                                    <h5 class="mb-0">{{ $borrowedBooks }}</h5>
                                    <p class="text-muted mb-0">Buku Dipinjam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Catat Peminjaman -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary d-block h-100 w-100">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <i class="fas fa-plus fa-2x mb-2"></i>
                            <span>Catat Peminjaman</span>
                        </div>
                    </a>
                </div>
            </div>




            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    Aktivitas Hari Ini
                                </h5>

                            </div>
                        </div>
                        <div class="card-body">

                            @if ($recentLoans->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Santri</th>
                                                <th>Buku</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Tanggal Kembali</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentLoans as $loan)
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
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                                <i class="fas fa-user text-white"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $loan->user->nama }}</h6>
                                                                <small
                                                                    class="text-muted">{{ $loan->user->kelas ?? 'N/A' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-0">{{ $loan->book->judul }}</h6>
                                                        <small class="text-muted">{{ $loan->book->kategori ?? '-' }}</small>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tanggalPinjam = \Carbon\Carbon::parse(
                                                                $loan->tanggal_pinjam,
                                                            );
                                                        @endphp
                                                        <div>
                                                            {{ $tanggalPinjam->translatedFormat('d F Y') }}
                                                            @if ($tanggalPinjam->isToday())
                                                                <span class="badge bg-success ms-1">Hari Ini</span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>
                                                        @php
                                                            $tanggalKembali = $loan->tanggal_kembali
                                                                ? \Carbon\Carbon::parse($loan->tanggal_kembali)
                                                                : null;
                                                        @endphp
                                                        <div>
                                                            @if ($tanggalKembali)
                                                                {{ $tanggalKembali->translatedFormat('d F Y') }}
                                                                @if ($tanggalKembali->isToday())
                                                                    <span class="badge bg-info text-dark ms-1">Hari
                                                                        Ini</span>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    @php
                                                        // Ambil status asli dari database
                                                        $status = $loan->status;

                                                        // Kalau masih dipinjam tapi sudah lewat tenggat, tandai sebagai terlambat
                                                        if (
                                                            $status === 'dipinjam' &&
                                                            $loan->tanggal_tenggat &&
                                                            \Carbon\Carbon::parse($loan->tanggal_tenggat)->isPast()
                                                        ) {
                                                            $status = 'terlambat';
                                                        }
                                                    @endphp

                                                    <td>
                                                        <span class="status-badge status-{{ $status }}">
                                                            @if ($status == 'dipinjam')
                                                                <i class="fas fa-clock me-1"></i> Dipinjam
                                                            @elseif ($status == 'dikembalikan')
                                                                <i class="fas fa-check-circle me-1"></i> Dikembalikan
                                                            @else
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Terlambat
                                                            @endif
                                                        </span>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada aktivitas</h5>
                                    <p class="text-muted">Aktivitas peminjaman akan muncul di sini</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        @endsection

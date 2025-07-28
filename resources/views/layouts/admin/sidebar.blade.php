<nav class="nav flex-column">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
    <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
        <i class="fas fa-book"></i>
        Buku
    </a>
    <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}" href="{{ route('pengguna.index') }}">
        <i class="fas fa-users"></i>
        Santri
    </a>
    <a class="nav-link {{ request()->routeIs('rak.*') ? 'active' : '' }}" href="{{ route('rak.index') }}">
        <i class="fas fa-archive"></i> Rak Buku
        Rak
    </a>
    <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
        <i class="fas fa-hand-holding"></i>
        Peminjaman
    </a>
    <a class="nav-link {{ request()->routeIs('riwayat.pengembalian') ? 'active' : '' }}"
        href="{{ route('riwayat.pengembalian') }}">
        <i class="fas fa-undo-alt"></i> Pengembalian
    </a>
    <!-- Menu Laporan -->
    <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" data-bs-toggle="collapse"
        href="#submenuLaporan" role="button" aria-expanded="{{ request()->routeIs('laporan.*') ? 'true' : 'false' }}"
        aria-controls="submenuLaporan" title="Lihat laporan peminjaman buku">
        <i class="fas fa-chart-bar me-2"></i>
        Laporan
    </a>

    <!-- Submenu Laporan -->
    <div class="collapse {{ request()->routeIs('laporan.*') ? 'show' : '' }}" id="submenuLaporan">
        <nav class="nav flex-column ms-4">
            <a class="nav-link {{ request()->routeIs('laporan.tanggal') ? 'active' : '' }}"
                href="{{ route('laporan.tanggal') }}">
                Berdasarkan Tanggal/Bulan/Tahun
            </a>
            <a class="nav-link {{ request()->routeIs('laporan.santri') ? 'active' : '' }}"
                href="{{ route('laporan.santri') }}">
                Per Santri / Per Buku
            </a>
            <a class="nav-link {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}"
                href="{{ route('laporan.peminjaman') }}">
                Peminjaman
            </a>
            <a class="nav-link {{ request()->routeIs('laporan.pengembalian') ? 'active' : '' }}"
                href="{{ route('laporan.pengembalian') }}">
                Pengembalian
            </a>
            <a class="nav-link {{ request()->routeIs('laporan.terlambat') ? 'active' : '' }}"
                href="{{ route('laporan.terlambat') }}">
                Terlambat
            </a>

        </nav>
    </div>


</nav>

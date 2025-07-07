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
        Pengguna
    </a>
    <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
        <i class="fas fa-hand-holding"></i>
        Peminjaman
    </a>
    <a class="nav-link {{ request()->routeIs('riwayat.pengembalian') ? 'active' : '' }}"
        href="{{ route('riwayat.pengembalian') }}">
        <i class="fas fa-undo-alt"></i> Pengembalian
    </a>
    <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
        <i class="fas fa-chart-bar"></i>
        Laporan
    </a>
    <a class="nav-link {{ request()->routeIs('pengaturan') ? 'active' : '' }}" href="{{ route('pengaturan') }}">
        <i class="fas fa-cog"></i>
        Pengaturan
    </a>
</nav>

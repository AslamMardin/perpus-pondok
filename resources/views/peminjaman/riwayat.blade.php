@extends('layouts.admin')
@section('title', 'Riwayat Pengembalian')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Riwayat Pengembalian</h4>
    </div>

    <form method="GET" class="mb-3 row g-2">
        <div class="col-md-4">
            <select name="kelas" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @foreach ($daftarKelas as $k)
                    <option value="{{ $k }}" {{ $k == $kelas ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Santri</th>
                    <th>Kelas</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $i => $loan)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $loan->user->nama }}</td>
                        <td>{{ $loan->user->kelas }}</td>
                        <td>{{ $loan->book->judul }}</td>
                        <td>{{ $loan->tanggal_pinjam }}</td>
                        <td>{{ $loan->tanggal_kembali }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data pengembalian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

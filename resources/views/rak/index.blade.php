@extends('layouts.admin')
@section('title', 'Daftar Rak Perpustakaan')
@section('content')
    <div class="page-header">
        <h1 class="mb-0">Data Rak Buku</h1>
    </div>

    <div class="mb-4">
        <a href="{{ route('rak.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Rak
        </a>
    </div>

    <div class="card p-3 fade-in">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raks as $rak)
                        <tr>
                            <td>{{ $rak->nama }}</td>
                            <td>{{ $rak->lokasi }}</td>
                            <td>{{ $rak->keterangan }}</td>
                            <td>
                                <a href="{{ route('rak.edit', $rak) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('rak.destroy', $rak) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus rak ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($raks->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data rak.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

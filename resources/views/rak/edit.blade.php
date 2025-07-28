@extends('layouts.admin')
@section('title', 'Edit Rak')
@section('content')
    <div class="page-header">
        <h1 class="mb-0">Edit Rak Buku</h1>
    </div>

    <div class="card p-4 fade-in">
        <form action="{{ route('rak.update', $rak) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Rak</label>
                <input type="text" class="form-control" id="nama" name="nama" required
                    value="{{ old('nama', $rak->nama) }}">
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi"
                    value="{{ old('lokasi', $rak->lokasi) }}">
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan">{{ old('keterangan', $rak->keterangan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('rak.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection

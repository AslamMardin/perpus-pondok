@extends('layouts.admin')

@section('title', 'Edit Buku')

@section('content')
    <div class="container mt-4">
        <div class="page-header">
            <h4 class="mb-0">Edit Data Buku</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" id="judul" name="judul" class="form-control"
                    value="{{ old('judul', $buku->judul) }}" required>
            </div>



            <div class="mb-3">
                <label for="rak_id" class="form-label">Rak Buku</label>
                <select name="rak_id" id="rak_id" class="form-select" required>
                    <option value="">-- Pilih Rak --</option>
                    @foreach ($raks as $rak)
                        <option value="{{ $rak->id }}"
                            {{ old('rak_id', $buku->rak_id) == $rak->id ? 'selected' : '' }}>
                            {{ $rak->kode }} - {{ $rak->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection

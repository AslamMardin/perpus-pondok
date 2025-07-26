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
                <label for="kategori" class="form-label">Kategori Buku</label>
                <select name="kategori" id="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @php
                        $kategoriList = [
                            'Formal' => 'Formal (Pelajaran Sekolah)',
                            'Novel' => 'Novel',
                            'Sejarah' => 'Sejarah',
                            'Agama' => 'Agama (Kitab, Fikih, Tauhid)',
                            'Bahasa' => 'Bahasa (Arab, Inggris, Indonesia)',
                            'Motivasi' => 'Motivasi & Pengembangan Diri',
                            'Biografi' => 'Biografi Tokoh Islam',
                            'Referensi' => 'Referensi (Kamus, Ensiklopedia)',
                        ];
                    @endphp
                    @foreach ($kategoriList as $value => $label)
                        <option value="{{ $value }}"
                            {{ old('kategori', $buku->kategori) == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rak" class="form-label">Rak Buku</label>
                <select name="rak" id="rak" class="form-select" required>
                    <option value="">-- Pilih Rak --</option>
                    @php
                        $rakList = [
                            'A1' => 'A1 - Agama Dasar',
                            'A2' => 'A2 - Kitab Kuning',
                            'B1' => 'B1 - Bahasa Arab',
                            'B2' => 'B2 - Bahasa Inggris',
                            'F1' => 'F1 - Formal Pelajaran',
                            'N1' => 'N1 - Novel Islami',
                            'R1' => 'R1 - Referensi (Kamus, Ensiklopedia)',
                            'S1' => 'S1 - Sejarah & Biografi',
                            'dll' => 'Lain-Lain',
                        ];
                    @endphp
                    @foreach ($rakList as $value => $label)
                        <option value="{{ $value }}" {{ old('rak', $buku->rak) == $value ? 'selected' : '' }}>
                            {{ $label }}</option>
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

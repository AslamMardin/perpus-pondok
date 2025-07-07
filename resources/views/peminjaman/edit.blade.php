@extends('layouts.admin')
@section('title', 'Edit Peminjaman')

@section('content')
    <div class="page-header">
        <h4 class="mb-0">Edit Data Peminjaman</h4>
    </div>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @method('PUT')
        @include('peminjaman.form')
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

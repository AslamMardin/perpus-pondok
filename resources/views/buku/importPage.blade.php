@extends('layouts.admin')

@section('title', 'Import Buku')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">📥 Import Data Buku</h5>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('buku.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit">Import Buku</button>
                </form>
            </div>
        </div>
    </div>
@endsection

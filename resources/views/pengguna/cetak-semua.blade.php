@extends('layouts.admin')

@section('title', 'Cetak Semua Kartu Perpustakaan')

@section('content')
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Semua
        </button>
    </div>

    <div class="card-grid">
        @foreach ($users as $user)
            <div class="card-item">
                <div class="card-container shadow position-relative">

                    <!-- Logo Background Transparan -->
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Background" class="logo-bg">

                    <!-- Logo Pondok di Sudut Kanan Atas -->
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Pondok" class="logo-pondok">

                    <!-- Konten Kartu -->
                    <div class="card-content d-flex align-items-center">
                        <!-- Foto User -->
                        <div class="photo me-2">
                            <img src="{{ asset('img/img-default.jpg') }}" alt="Foto" class="foto-user">
                        </div>

                        <!-- Informasi -->
                        <div class="info text-start">
                            <div class="label-header">KARTU PERPUSTAKAAN</div>
                            <div class="info-item"><span class="label">Nama</span>: {{ $user->nama }}</div>
                            <div class="info-item"><span class="label">Kelas</span>: {{ $user->kelas ?? '-' }}</div>
                            <div class="info-item"><span class="label">Peran</span>: {{ ucfirst($user->peran) }}</div>
                            <div class="info-item"><span class="label">ID</span>: {{ $user->id }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <style>
        /* Grid Kartu */
        .card-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .card-item {
            width: 32%;
            box-sizing: border-box;
        }

        /* Kartu */
        .card-container {
            background: linear-gradient(135deg, #00796b, #004d40);
            color: #fff;
            border-radius: 10px;
            padding: 10px;
            position: relative;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Logo background transparan */
        .logo-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 180px;
            opacity: 0.07;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        /* Logo pojok kanan atas */
        .logo-pondok {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 30px;
            height: 30px;
            object-fit: contain;
            z-index: 1;
        }

        /* Konten kartu */
        .card-content {
            position: relative;
            z-index: 2;
        }

        /* Foto user */
        .foto-user {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* Label header */
        .label-header {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 2px;
        }

        /* Informasi detail */
        .info-item {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .label {
            font-weight: bold;
            color: #ffe082;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .label-header {
                font-size: 8px;

            }

            /* Informasi detail */
            .info-item {
                font-size: 8px;
                margin-bottom: 1px;
            }



            .card-grid,
            .card-grid * {
                visibility: visible;
            }

            .card-grid {
                position: absolute;
                top: 10px;
                left: 10px;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush

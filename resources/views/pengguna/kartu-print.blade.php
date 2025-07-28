@extends('layouts.admin')

@section('title', 'Cetak Kartu Perpustakaan')

@section('content')
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>

    <div class="card-wrapper d-flex justify-content-center">
        <div class="card-item p-2">
            <div class="card-container shadow position-relative">

                <!-- Logo Background Transparan -->
                <img src="{{ asset('img/logo.png') }}" alt="Logo Background" class="logo-bg">

                <!-- Logo Pondok di Sudut Kanan Atas -->
                <img src="{{ asset('img/logo.png') }}" alt="Logo Pondok" class="logo-pondok">

                <!-- Konten Kartu -->
                <div class="card-content d-flex align-items-center">
                    <!-- Foto User -->
                    <div class="photo me-3">
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
    </div>
@endsection

@push('styles')
    <style>
        /* Wrapper */
        .card-wrapper {
            display: flex;
            justify-content: center;
            page-break-inside: avoid;
        }

        .card-item {
            width: 340px;
            box-sizing: border-box;
        }

        /* Kartu */
        .card-container {
            background: linear-gradient(135deg, #00796b, #004d40);
            color: #fff;
            border-radius: 10px;
            padding: 15px;
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
            width: 220px;
            opacity: 0.07;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        /* Logo pojok kanan atas */
        .logo-pondok {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 35px;
            height: 35px;
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
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* Label header */
        .label-header {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 2px;
        }

        /* Informasi detail */
        .info-item {
            font-size: 11px;
            margin-bottom: 3px;
        }

        .label {
            font-weight: bold;
            color: #ffe082;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .card-container {
                border: 1px dashed #000 !important;
                box-shadow: none !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .card-wrapper,
            .card-wrapper * {
                visibility: visible;
            }

            .card-wrapper {
                position: absolute;
                top: 10px;
                left: 10px;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush

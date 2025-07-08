@extends('layouts.admin')

@section('title', 'Cetak Barcode Buku')

@section('content')
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>

    <div class="label-container shadow p-4 mx-auto">
        <div class="row g-4 align-items-center">
            {{-- QR Code di kiri --}}
            <div class="col-auto">
                <div class="barcode-box">
                    {!! $barcodeSvg !!}
                    <div class="mt-1 text-center text-muted small">ID: {{ $buku->id }}</div>
                </div>
            </div>

            {{-- Logo dan Info Buku di kanan --}}
            <div class="col">
                <div class="info-box">
                    <div class="mb-2">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Pondok" style="height: 60px;">
                    </div>
                    <div class="text-label mb-1 fw-bold text-uppercase">BUKU PPM AL-IKHLASH LAMPOKO</div>
                    <div><strong>Judul:</strong> {{ $buku->judul }}</div>
                    <div><strong>Kategori:</strong> {{ $buku->kategori }}</div>
                    <div><strong>Rak:</strong> {{ $buku->rak ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .label-container {
            background-color: #fff;
            border: 1px solid #ddd;
            max-width: 600px;
        }

        .barcode-box svg {
            width: 120px !important;
            height: 120px !important;
        }

        .info-box {
            font-size: 14px;
            line-height: 1.4;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .label-container,
            .label-container * {
                visibility: visible;
            }

            .label-container {
                position: absolute;
                top: 30px;
                left: 30px;
                width: auto;
                box-shadow: none !important;
                border: none;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush

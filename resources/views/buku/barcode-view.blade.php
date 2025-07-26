@extends('layouts.admin')

@section('title', 'Cetak Barcode Buku')

@section('content')
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>

    <div class="barcode-wrapper d-flex flex-wrap justify-content-start">
        @for ($i = 0; $i < $jumlah; $i++)
            <div class="barcode-item p-2">
                <div class="label-container shadow p-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <div class="barcode-box text-center">
                                {!! $barcodeSvg !!}
                                <div class="mt-1 text-muted small">ID: {{ $buku->id }}</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="info-box">
                                <img src="{{ asset('img/logo.png') }}" alt="Logo Pondok" style="height: 40px;"
                                    class="mb-2">
                                <div class="text-label fw-bold text-uppercase small">BUKU PPM AL-IKHLASH LAMPOKO</div>
                                <div class="small"><strong>Judul:</strong> {{ $buku->judul }}</div>
                                <div class="small"><strong>Kategori:</strong> {{ $buku->kategori }}</div>
                                <div class="small"><strong>Rak:</strong> {{ $buku->rak ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

@endsection

@push('styles')
    <style>
        .barcode-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: flex-start;
            page-break-inside: avoid;
        }

        .barcode-item {
            width: 48%;
            /* 2 per baris */
            box-sizing: border-box;
        }

        .label-container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .barcode-box svg {
            width: 100px !important;
            height: 100px !important;
        }

        .info-box {
            font-size: 12px;
            line-height: 1.3;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .label-container {
                border: 1px dashed #000 !important;
                box-shadow: none !important;
            }

            .barcode-wrapper,
            .barcode-wrapper * {
                visibility: visible;
            }

            .barcode-wrapper {
                position: absolute;
                top: 10px;
                left: 10px;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .barcode-item {
                page-break-inside: avoid;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush

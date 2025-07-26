@extends('layouts.admin')

@section('title', 'Cetak Barcode Buku')

@section('content')
    <div class="no-print">
        <button onclick="window.print()" class="print-btn">🖨️ Cetak Barcode</button>
    </div>

    <div class="header no-print">
        <img src="{{ asset('img/logo.png') }}" class="logo" alt="Logo Pondok">
        <h2 class="title">PPM AL-IKHLASH LAMPOKO</h2>
        <h4>Daftar Barcode Semua Buku</h4>
    </div>

    <table class="barcode-table">
        @foreach ($books->chunk(2) as $chunk)
            <tr>
                @foreach ($chunk as $book)
                    <td>
                        <div class="barcode-box">
                            <div class="text-center">

                                <div>{!! QrCode::size(90)->generate($book->id) !!}</div>
                                <strong>ID:</strong> {{ $book->id }}
                            </div>
                            <div class="details">
                                <img src="{{ asset('img/logo.png') }}" alt="Logo Pondok" style="height: 40px;"
                                    class="mb-2">
                                <div class="text-label fw-bold text-uppercase small">BUKU PPM AL-IKHLASH LAMPOKO</div>
                                <strong>Judul:</strong> {{ $book->judul }}<br>
                                <strong>Kategori:</strong> {{ $book->kategori }}<br>
                                <strong>Rak:</strong> {{ $daftarRak[$book->rak] ?? $book->rak }}<br>
                            </div>
                        </div>
                    </td>
                @endforeach

                @if ($chunk->count() < 2)
                    <td></td> {{-- biar tabel tetap rapi --}}
                @endif
            </tr>
        @endforeach
    </table>

@endsection

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            /* margin: 20px; */
        }

        @media print {
            body {
                visibility: hidden;
            }

            .barcode-table,
            .barcode-table * {
                visibility: visible;
            }

            .barcode-table {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }

        .barcode-table {
            width: 100%;
            border-collapse: collapse;
        }

        .barcode-table td {
            padding: 15px;
            vertical-align: top;
            width: 50%;
        }

        .barcode-box {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 0;
            box-shadow: none;
            /* Hilangkan bayangan */
        }


        .barcode-box img {
            max-height: 80px;
        }

        .details {
            font-size: 13px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            height: 60px;
            margin-bottom: 10px;
        }

        .title {
            margin-top: 0;
            font-size: 18px;
        }

        .print-btn {
            background: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .print-btn:hover {
            background: #218838;
        }

        .text-label {
            font-size: 10px !important;
            font-weight: bold
        }
    </style>
@endpush

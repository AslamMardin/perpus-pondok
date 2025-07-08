<!DOCTYPE html>
<html>

<head>
    <title>Barcode Semua Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 20px;
        }

        @media print {
            .no-print {
                display: none;
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
            /* jarak antara barcode dan detail */
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 1px 1px 5px #eee;
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
    </style>
</head>

<body>

    <div class="no-print">
        <button onclick="window.print()" class="print-btn">🖨️ Cetak Barcode</button>
    </div>

    <div class="header">
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
                            <div>{!! QrCode::size(100)->generate($book->id) !!}</div>
                            <div class="details">
                                <strong>Judul:</strong> {{ $book->judul }}<br>
                                <strong>Kategori:</strong> {{ $book->kategori }}<br>
                                <strong>Rak:</strong> {{ $book->rak ?? '-' }}<br>
                                <strong>ID:</strong> {{ $book->id }}
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

</body>

</html>

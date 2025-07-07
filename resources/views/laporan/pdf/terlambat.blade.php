<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Terlambat</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3 {
            margin-bottom: 0;
        }

        p {
            margin-top: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h3>Laporan Peminjaman Terlambat</h3>
    <p>Tanggal cetak: {{ now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Santri</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Tenggat</th>
                <th>Tanggal Kembali</th>
                <th>Keterlambatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $i => $loan)
                @php
                    $tenggat = \Carbon\Carbon::parse($loan->tanggal_tenggat);
                    $kembali = $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali) : now();
                    $terlambat = $kembali->greaterThan($tenggat) ? $tenggat->diffInDays($kembali) : 0;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $loan->user->nama }}</td>
                    <td>{{ $loan->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                    <td>{{ $tenggat->translatedFormat('d F Y') }}</td>
                    <td>
                        {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td>
                        @if ($terlambat > 0)
                            {{ $terlambat }} hari
                        @else
                            Tepat waktu
                        @endif
                    </td>
                    <td>{{ ucfirst($loan->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

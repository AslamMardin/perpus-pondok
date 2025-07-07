<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3 style="text-align:center;">Laporan Peminjaman Buku</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Santri</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Tenggat</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $i => $loan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $loan->user->nama }}</td>
                    <td>{{ $loan->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_tenggat)->translatedFormat('d F Y') }}</td>
                    <td>{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td>{{ ucfirst($loan->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

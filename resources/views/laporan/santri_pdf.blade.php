<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman - {{ $santri->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h3>Laporan Peminjaman Buku</h3>
    <p><strong>Nama Santri:</strong> {{ $santri->nama }} | <strong>Kelas:</strong> {{ $santri->kelas }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Tenggat</th>
                <th>Tgl Kembali</th>
                <th>Status Telat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $i => $loan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $loan->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_tenggat)->format('d-m-Y') }}</td>
                    <td>{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $loan->tanggal_kembali && $loan->tanggal_kembali > $loan->tanggal_tenggat ? 'Terlambat' : 'Tepat Waktu' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

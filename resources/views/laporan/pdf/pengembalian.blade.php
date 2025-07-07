<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian Buku</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #333;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            color: white;
            font-size: 10px;
        }

        .badge-success {
            background-color: green;
        }
    </style>
</head>

<body>
    <h2>Laporan Pengembalian Buku</h2>
    <p>PPM Al-Ikhlash Lampoko - Dicetak pada {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th class="text-left">Nama Santri</th>
                <th class="text-left">Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $i => $loan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-left">{{ $loan->user->nama }}</td>
                    <td class="text-left">{{ $loan->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d F Y') }}</td>
                    <td>
                        <span class="badge badge-success">{{ ucfirst($loan->status) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data pengembalian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>

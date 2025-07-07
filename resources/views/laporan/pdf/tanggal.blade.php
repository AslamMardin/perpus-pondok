<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Berdasarkan Tanggal</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }
    </style>
</head>

<body>
    {{-- Fungsi Format Tanggal --}}
    @php
        function tgl_indo($tanggal)
        {
            return \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y');
        }
    @endphp

    {{-- Header Laporan --}}
    <h3>Laporan Peminjaman Buku</h3>
    <p>Periode: {{ tgl_indo($dari) }} s.d. {{ tgl_indo($sampai) }}</p>

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Santri</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Tenggat</th>
                <th>Tanggal Kembali</th>
                <th>Status Telat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $i => $loan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $loan->user->nama }}</td>
                    <td>{{ $loan->book->judul }}</td>
                    <td>{{ tgl_indo($loan->tanggal_pinjam) }}</td>
                    <td>{{ tgl_indo($loan->tanggal_tenggat) }}</td>
                    <td>
                        @if ($loan->tanggal_kembali)
                            {{ tgl_indo($loan->tanggal_kembali) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($loan->tanggal_kembali && $loan->tanggal_kembali > $loan->tanggal_tenggat)
                            <span class="text-danger">Terlambat</span>
                        @else
                            <span class="text-success">Tepat Waktu</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($loan->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

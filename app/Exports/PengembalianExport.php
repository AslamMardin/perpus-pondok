<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengembalianExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Loan::with(['user', 'book'])
            ->where('status', 'dikembalikan')
            ->get()
            ->map(function ($loan) {
                return [
                    'nama_santri' => $loan->user->nama,
                    'judul_buku' => $loan->book->judul,
                    'tanggal_pinjam' => $loan->tanggal_pinjam,
                    'tanggal_kembali' => $loan->tanggal_kembali,
                    'status' => $loan->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Santri',
            'Judul Buku',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
        ];
    }
}


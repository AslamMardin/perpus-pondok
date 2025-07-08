<?php

namespace App\Exports;

use App\Models\Loan;
use Carbon\Carbon;
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
                    'Nama Santri' => $loan->user->nama,
                    'Judul Buku' => $loan->book->judul,
                    'Tanggal Pinjam' => Carbon::parse($loan->tanggal_pinjam)->translatedFormat('j F Y'),
                    'Tanggal Kembali' => $loan->tanggal_kembali
                        ? Carbon::parse($loan->tanggal_kembali)->translatedFormat('j F Y')
                        : '-',
                    'Status' => ucfirst($loan->status),
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

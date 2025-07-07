<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TerlambatExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Loan::with(['user', 'book'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_tenggat', '<', now())
            ->get()
            ->map(function ($loan) {
                return [
                    'nama_santri' => $loan->user->nama,
                    'judul_buku' => $loan->book->judul,
                    'tanggal_pinjam' => $loan->tanggal_pinjam,
                    'tanggal_tenggat' => $loan->tanggal_tenggat,
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
            'Tanggal Tenggat',
            'Status',
        ];
    }
}

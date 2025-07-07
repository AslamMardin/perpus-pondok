<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanTanggalExport implements FromCollection, WithHeadings
{
    protected $dari;
    protected $sampai;

    public function __construct($dari, $sampai)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        return Loan::with(['user', 'book'])
            ->whereBetween('tanggal_pinjam', [$this->dari, $this->sampai])
            ->orderBy('tanggal_pinjam', 'asc')
            ->get()
            ->map(function ($loan) {
                return [
                    'Nama Santri' => $loan->user->nama,
                    'Judul Buku' => $loan->book->judul,
                    'Tanggal Pinjam' => $loan->tanggal_pinjam,
                    'Tanggal Tenggat' => $loan->tanggal_tenggat,
                    'Tanggal Kembali' => $loan->tanggal_kembali ?? '-',
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
            'Tanggal Tenggat',
            'Tanggal Kembali',
            'Status',
        ];
    }
}

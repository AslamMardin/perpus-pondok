<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class BookTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            ['judul', 'rak_id'], // Header kolom
            ['Contoh Buku 1', '1'],
            ['Contoh Buku 2', '2'],
        ];
    }
}
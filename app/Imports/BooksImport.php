<?php

namespace App\Imports;

use App\Models\Rak;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if ($row['rak_id'] && !Rak::find($row['rak_id'])) {
            throw ValidationException::withMessages([
                'rak_id' => "Rak ID {$row['rak_id']} tidak ditemukan"
            ]);
        }

        return new Book([
            'judul'  => $row['judul'],
            'rak_id' => $row['rak_id'] ?: null,
        ]);
    }
}
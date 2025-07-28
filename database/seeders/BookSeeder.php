<?php

namespace Database\Seeders;

use App\Models\Rak;
use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $rakA1 = Rak::where('nama', 'Sejarah')->first();
        $rakB2 = Rak::where('nama', 'Agama')->first();

        Book::create([
            'judul' => 'Sirah Nabawiyah',
            'rak_id' => $rakA1->id ?? null
        ]);

        Book::create([
            'judul' => 'Fiqh Ibadah',
            'rak_id' => $rakB2->id ?? null
        ]);
    }
}
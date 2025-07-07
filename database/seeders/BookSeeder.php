<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::create([
            'judul' => 'Sirah Nabawiyah',
            'kategori' => 'Sejarah',
            'rak' => 'A1'
        ]);

        Book::create([
            'judul' => 'Fiqh Ibadah',
            'kategori' => 'Agama',
            'rak' => 'B2'
        ]);
    }
}
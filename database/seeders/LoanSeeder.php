<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        Loan::create([
            'user_id' => 2,
            'book_id' => 1,
            'tanggal_pinjam' => now()->subDays(2),
            'tanggal_tenggat' => now()->addDays(5),
            'tanggal_kembali' => null, // Belum dikembalikan
        ]);
    }
}

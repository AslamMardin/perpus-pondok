<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $raks = ['Formal', 'Agama', 'Sejarah', 'Informatika', 'Novel', 'Umum'];

        foreach ($raks as $rak) {
            DB::table('raks')->insert([
                'nama' => $rak,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SantriKelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = [];

        foreach (range('A', 'D') as $huruf) {
            $kelasList[] = "7 $huruf";
            $kelasList[] = "8 $huruf";
        }

        foreach (range('A', 'C') as $huruf) {
            $kelasList[] = "9 $huruf";
        }

        foreach (range(1, 4) as $i) {
            $kelasList[] = "10 Merdeka $i";
            $kelasList[] = "11 Merdeka $i";
        }

        foreach (range(1, 3) as $i) {
            $kelasList[] = "12 Mipa $i";
        }

        foreach ($kelasList as $kelas) {
            DB::table('users')->insert([
                'nama' => $kelas,
                'username' => strtolower(str_replace(' ', '_', $kelas)),
                'password' => Hash::make('12345678'),
                'kelas' => $kelas,
                'peran' => 'santri',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

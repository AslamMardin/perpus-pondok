<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SantriKelasSeeder extends Seeder
{
    public function run(): void
    {
        // $kelasList = [];

        // // Jenjang MTs & SMP untuk kelas 7 - 9
        // $jenjangs = ['SMP', 'MTs'];
        // $kelasRange = [
        //     7 => ['A', 'B', 'C', 'D'],
        //     8 => ['A', 'B', 'C', 'D'],
        //     9 => ['A', 'B', 'C']
        // ];

        // foreach ($kelasRange as $tingkat => $hurufList) {
        //     foreach ($hurufList as $huruf) {
        //         foreach ($jenjangs as $jenjang) {
        //             $kelasList[] = [
        //                 'kelas' => "$tingkat $huruf",
        //                 'jenjang' => $jenjang,
        //             ];
        //         }
        //     }
        // }

        // // Kelas MA (10-12)
        // foreach (range(1, 4) as $i) {
        //     $kelasList[] = [
        //         'kelas' => "10 Merdeka $i",
        //         'jenjang' => 'MA',
        //     ];
        //     $kelasList[] = [
        //         'kelas' => "11 Merdeka $i",
        //         'jenjang' => 'MA',
        //     ];
        // }

        // foreach (range(1, 3) as $i) {
        //     $kelasList[] = [
        //         'kelas' => "12 Mipa $i",
        //         'jenjang' => 'MA',
        //     ];
        // }

        // // Insert ke tabel users
        // foreach ($kelasList as $item) {
        //     $kelasLengkap = $item['kelas'] . ' ' . $item['jenjang'];
        //     $username = strtolower(str_replace([' ', '-'], '_', $kelasLengkap));

        //     DB::table('users')->insert([
        //         'nama' => $kelasLengkap,
        //         'username' => $username,
        //         'password' => Hash::make('12345678'),
        //         'kelas' => $kelasLengkap,
        //         'peran' => 'santri',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}

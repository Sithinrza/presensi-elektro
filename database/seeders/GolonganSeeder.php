<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder {
    public function run(): void {
        $now = now();
        DB::table('golongan')->insert([
            // Tanpa Golongan (Honorer / Kontrak)
            ['ruang' => '-', 'jenis' => '-', 'created_at' => $now, 'updated_at' => $now],       // ID 1

            // Golongan PNS (17 Tingkat)
            ['ruang' => 'I/a', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],   // ID 2
            ['ruang' => 'I/b', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],   // ID 3
            ['ruang' => 'I/c', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],   // ID 4
            ['ruang' => 'I/d', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],   // ID 5
            ['ruang' => 'II/a', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 6
            ['ruang' => 'II/b', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 7
            ['ruang' => 'II/c', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 8
            ['ruang' => 'II/d', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 9
            ['ruang' => 'III/a', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now], // ID 10
            ['ruang' => 'III/b', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now], // ID 11
            ['ruang' => 'III/c', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now], // ID 12
            ['ruang' => 'III/d', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now], // ID 13
            ['ruang' => 'IV/a', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 14
            ['ruang' => 'IV/b', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 15
            ['ruang' => 'IV/c', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 16
            ['ruang' => 'IV/d', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 17
            ['ruang' => 'IV/e', 'jenis' => 'PNS', 'created_at' => $now, 'updated_at' => $now],  // ID 18

            // Golongan PPPK (17 Tingkat)
            ['ruang' => 'I', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],    // ID 19
            ['ruang' => 'II', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],   // ID 20
            ['ruang' => 'III', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],  // ID 21
            ['ruang' => 'IV', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],   // ID 22
            ['ruang' => 'V', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],    // ID 23
            ['ruang' => 'VI', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],   // ID 24
            ['ruang' => 'VII', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],  // ID 25
            ['ruang' => 'VIII', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now], // ID 26
            ['ruang' => 'IX', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],   // ID 27
            ['ruang' => 'X', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],    // ID 28
            ['ruang' => 'XI', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],   // ID 29
            ['ruang' => 'XII', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],  // ID 30
            ['ruang' => 'XIII', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now], // ID 31
            ['ruang' => 'XIV', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],  // ID 32
            ['ruang' => 'XV', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],   // ID 33
            ['ruang' => 'XVI', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now],  // ID 34
            ['ruang' => 'XVII', 'jenis' => 'PPPK', 'created_at' => $now, 'updated_at' => $now], // ID 35
        ]);
    }
}

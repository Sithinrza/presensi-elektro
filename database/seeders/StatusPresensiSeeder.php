<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPresensiSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('status_presensi')->insert([
            ['name' => 'Tepat Waktu', 'created_at' => $now, 'updated_at' => $now],    // Otomatis ID 1
            ['name' => 'Terlambat', 'created_at' => $now, 'updated_at' => $now],      // Otomatis ID 2
            ['name' => 'Alfa', 'created_at' => $now, 'updated_at' => $now],           // Otomatis ID 3
            ['name' => 'Check Out', 'created_at' => $now, 'updated_at' => $now],   // Otomatis ID 4
            ['name' => 'Lupa Check-Out', 'created_at' => $now, 'updated_at' => $now], // Otomatis ID 5
        ]);
    }
}

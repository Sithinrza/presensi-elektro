<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('status_presensi')->insert([
            ['name' => 'Hadir', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Terlambat', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Alfa', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

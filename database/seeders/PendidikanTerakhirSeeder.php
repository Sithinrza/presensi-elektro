<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanTerakhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('pendidikan_terakhir')->insert([
            ['name' => 'SMA/SMK', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'D3', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'D4', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'S1', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'S2', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

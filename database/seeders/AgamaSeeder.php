<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('agama')->insert([
            ['name' => 'Islam', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kristen', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Katolik', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Hindu', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Buddha', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Konghucu', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

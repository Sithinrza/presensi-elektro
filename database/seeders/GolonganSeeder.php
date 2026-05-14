<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder {
    public function run(): void {
        DB::table('golongan')->insert([
            ['ruang' => 'II/b', 'created_at' => now(), 'updated_at' => now()],  // ID 1
            ['ruang' => 'III/a', 'created_at' => now(), 'updated_at' => now()], // ID 2
            ['ruang' => 'III/b', 'created_at' => now(), 'updated_at' => now()], // ID 3
            ['ruang' => 'III/c', 'created_at' => now(), 'updated_at' => now()], // ID 4
            ['ruang' => 'III/d', 'created_at' => now(), 'updated_at' => now()], // ID 5
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('roles')->insert([
            ['name' => 'admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'tendik', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'siswa', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'pembimbing', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

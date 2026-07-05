<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $now = now();
        DB::table('unit_kerja')->insert([
            ['nama_unit' => '-', 'created_at' => $now, 'updated_at' => $now],
            ['nama_unit' => 'Jurusan Teknik Elektro', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

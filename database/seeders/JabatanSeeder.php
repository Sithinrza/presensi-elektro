<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder {
    public function run(): void {
        $now = now();
        DB::table('jabatan')->insert([
            ['nama_jabatan' => '-', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jabatan' => 'Tenaga Kependidikan', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jabatan' => 'Staf Tata Usaha', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jabatan' => 'Teknisi Laboratorium', 'created_at' => $now, 'updated_at' => $now],
            ['nama_jabatan' => 'Pranata Laboratorium Pendidikan', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

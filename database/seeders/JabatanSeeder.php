<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder {
    public function run(): void {
        DB::table('jabatan')->insert([
            ['nama_jabatan' => 'Terampil Penyelia', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Ahli Muda', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Pengolah Data Akademik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Ahli Pratama', 'created_at' => now(), 'updated_at' => now()],
            ['nama_jabatan' => 'Terampil Pelaksana Lanjutan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

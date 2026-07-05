<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatSeeder extends Seeder {
    public function run(): void {
        $now = now();
        DB::table('pangkat')->insert([
            // Tanpa Pangkat
            ['nama_pangkat' => '-', 'created_at' => $now, 'updated_at' => $now],                  // ID 1

            // Pangkat PNS Golongan I
            ['nama_pangkat' => 'Juru Muda', 'created_at' => $now, 'updated_at' => $now],          // ID 2
            ['nama_pangkat' => 'Juru Muda Tk.I', 'created_at' => $now, 'updated_at' => $now],     // ID 3
            ['nama_pangkat' => 'Juru', 'created_at' => $now, 'updated_at' => $now],               // ID 4
            ['nama_pangkat' => 'Juru Tk.I', 'created_at' => $now, 'updated_at' => $now],          // ID 5

            // Pangkat PNS Golongan II
            ['nama_pangkat' => 'Pengatur Muda', 'created_at' => $now, 'updated_at' => $now],      // ID 6
            ['nama_pangkat' => 'Pengatur Muda Tk.I', 'created_at' => $now, 'updated_at' => $now], // ID 7
            ['nama_pangkat' => 'Pengatur', 'created_at' => $now, 'updated_at' => $now],           // ID 8
            ['nama_pangkat' => 'Pengatur Tk.I', 'created_at' => $now, 'updated_at' => $now],      // ID 9

            // Pangkat PNS Golongan III
            ['nama_pangkat' => 'Penata Muda', 'created_at' => $now, 'updated_at' => $now],        // ID 10
            ['nama_pangkat' => 'Penata Muda Tk.I', 'created_at' => $now, 'updated_at' => $now],   // ID 11
            ['nama_pangkat' => 'Penata', 'created_at' => $now, 'updated_at' => $now],             // ID 12
            ['nama_pangkat' => 'Penata Tk.I', 'created_at' => $now, 'updated_at' => $now],        // ID 13

            // Pangkat PNS Golongan IV
            ['nama_pangkat' => 'Pembina', 'created_at' => $now, 'updated_at' => $now],            // ID 14
            ['nama_pangkat' => 'Pembina Tk.I', 'created_at' => $now, 'updated_at' => $now],       // ID 15
            ['nama_pangkat' => 'Pembina Utama Muda', 'created_at' => $now, 'updated_at' => $now], // ID 16
            ['nama_pangkat' => 'Pembina Utama Madya', 'created_at' => $now, 'updated_at' => $now], // ID 17
            ['nama_pangkat' => 'Pembina Utama', 'created_at' => $now, 'updated_at' => $now],      // ID 18

            // Pangkat PPPK
            ['nama_pangkat' => 'Pegawai Pemerintah (PPPK)', 'created_at' => $now, 'updated_at' => $now], // ID 19
        ]);
    }
}

<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatGolonganSeeder extends Seeder {
    public function run(): void {
        DB::table('pangkat_golongan')->insert([
            ['id_pangkat' => 1, 'id_golongan' => 1, 'created_at' => now(), 'updated_at' => now()], // Pengatur Muda Tk.I - II/b
            ['id_pangkat' => 2, 'id_golongan' => 2, 'created_at' => now(), 'updated_at' => now()], // Penata Muda - III/a
            ['id_pangkat' => 3, 'id_golongan' => 3, 'created_at' => now(), 'updated_at' => now()], // Penata Muda Tk.I - III/b
            ['id_pangkat' => 4, 'id_golongan' => 4, 'created_at' => now(), 'updated_at' => now()], // Penata - III/c
            ['id_pangkat' => 5, 'id_golongan' => 5, 'created_at' => now(), 'updated_at' => now()], // Penata Tk.I - III/d
        ]);
    }
}

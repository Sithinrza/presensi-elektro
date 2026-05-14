<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatSeeder extends Seeder {
    public function run(): void {
        DB::table('pangkat')->insert([
            ['nama_pangkat' => 'Pengatur Muda Tk.I', 'created_at' => now(), 'updated_at' => now()], // ID 1
            ['nama_pangkat' => 'Penata Muda', 'created_at' => now(), 'updated_at' => now()],        // ID 2
            ['nama_pangkat' => 'Penata Muda Tk.I', 'created_at' => now(), 'updated_at' => now()],   // ID 3
            ['nama_pangkat' => 'Penata', 'created_at' => now(), 'updated_at' => now()],             // ID 4
            ['nama_pangkat' => 'Penata Tk.I', 'created_at' => now(), 'updated_at' => now()],        // ID 5
        ]);
    }
}

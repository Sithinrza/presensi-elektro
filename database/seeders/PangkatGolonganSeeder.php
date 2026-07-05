<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatGolonganSeeder extends Seeder {
    public function run(): void {
        $now = now();
        $data = [
            // Mapping untuk Honorer/Kontrak
            ['id_pangkat' => 1, 'id_golongan' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        // Mapping PNS (ID Pangkat 2-18 berpasangan dengan ID Golongan 2-18)
        for ($i = 2; $i <= 18; $i++) {
            $data[] = [
                'id_pangkat' => $i,
                'id_golongan' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        // Mapping PPPK (Semua Golongan PPPK ID 19-35 dipetakan ke ID Pangkat 19)
        for ($i = 19; $i <= 35; $i++) {
            $data[] = [
                'id_pangkat' => 19,
                'id_golongan' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        DB::table('pangkat_golongan')->insert($data);
    }
}

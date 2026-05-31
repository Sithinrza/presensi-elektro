<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Wajib di-import untuk fitur disable foreign key

class StatusPresensiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Matikan penjaga relasi (Foreign Key) sementara biar nggak error pas dikosongkan
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel secara total & kembalikan Auto-Increment ke angka 1
        DB::table('status_presensi')->truncate();

        // 3. Nyalakan lagi penjaga relasinya
        Schema::enableForeignKeyConstraints();

        $now = now();

        // 4. Masukkan data dengan mendefinisikan ID secara pasti
        DB::table('status_presensi')->insert([
            ['id_status_presensi' => 1, 'name' => 'Tepat Waktu', 'created_at' => $now, 'updated_at' => $now],
            ['id_status_presensi' => 2, 'name' => 'Terlambat', 'created_at' => $now, 'updated_at' => $now],
            ['id_status_presensi' => 3, 'name' => 'Alfa', 'created_at' => $now, 'updated_at' => $now],
            ['id_status_presensi' => 4, 'name' => 'Check Out', 'created_at' => $now, 'updated_at' => $now],
            ['id_status_presensi' => 5, 'name' => 'Lupa Check-Out', 'created_at' => $now, 'updated_at' => $now],
            ['id_status_presensi' => 6, 'name' => 'Libur', 'created_at' => $now, 'updated_at' => $now], // Pakai ID 11 sesuai screenshot kamu
        ]);
    }
}

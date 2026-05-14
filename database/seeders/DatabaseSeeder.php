<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AgamaSeeder::class,
            PendidikanTerakhirSeeder::class,
            UnitKerjaSeeder::class,
            StatusPresensiSeeder::class,

            // Urutan tabel Normalisasi Pangkat & Jabatan
            PangkatSeeder::class,
            GolonganSeeder::class,
            PangkatGolonganSeeder::class,
            JabatanSeeder::class,

            // User dibuat paling akhir karena dia butuh Role
            UserSeeder::class,
        ]);
    }
}

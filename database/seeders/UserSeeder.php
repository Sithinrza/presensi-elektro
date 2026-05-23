<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $now = now();

        // 1. Buat data user Admin
        $userId = DB::table('users')->insertGetId([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Hubungkan ke Role Admin (ID Role 1 = Admin)
        DB::table('role_user')->insert([
            'id_user' => $userId,
            'id_role' => 1,
        ]);
    }
}

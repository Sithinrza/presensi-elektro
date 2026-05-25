<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id('id_presensi');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            $table->foreignId('id_status_ci')->constrained('status_presensi', 'id_status_presensi');
            $table->foreignId('id_status_co')->nullable()->constrained('status_presensi', 'id_status_presensi'); // Nullable karena pas CI, CO belum ada status

            $table->date('tanggal');

            // Check-In
            $table->time('jam_masuk')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->decimal('latitude_masuk', 10, 8)->nullable();
            $table->decimal('longitude_masuk', 11, 8)->nullable();

            // Check-Out
            $table->time('jam_pulang')->nullable();
            $table->string('foto_pulang')->nullable();
            $table->decimal('latitude_pulang', 10, 8)->nullable();
            $table->decimal('longitude_pulang', 11, 8)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('klaim_presensi', function (Blueprint $table) {
            $table->id('id_klaim_presensi');

            $table->foreignId('id_presensi')
                  ->constrained('presensi', 'id_presensi')
                  ->onDelete('cascade');

            $table->text('alasan');
            $table->string('dokumen_bukti')->nullable(); 
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');

            // Relasi ke tabel users (siapa admin yang memverifikasi)
            $table->foreignId('diverifikasi_oleh')
                  ->nullable()
                  ->constrained('users', 'id_user')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klaim_presensi');
    }
};

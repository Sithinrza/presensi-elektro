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
        Schema::create('penilaian_magang', function (Blueprint $table) {
            $table->id('id_penilaian'); // Primary Key

            // Relasi ke Siswa dan Pembimbing
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_user');

            $table->string('nomor_sertifikat')->nullable();

            // Tipe decimal(5,2) berarti bisa menampung angka seperti 10.00 atau 8.50
            $table->decimal('kecakapan_kerja', 5, 2)->default(0);
            $table->decimal('menerima_perintah', 5, 2)->default(0);
            $table->decimal('sikap_perilaku', 5, 2)->default(0);
            $table->decimal('inisiatif_kreatifitas', 5, 2)->default(0);
            $table->decimal('disiplin_kehadiran', 5, 2)->default(0);
            $table->decimal('tanggung_jawab', 5, 2)->default(0);

            // --- 4 ASPEK KETERAMPILAN ---
            $table->decimal('pemahaman_teknis', 5, 2)->default(0);
            $table->decimal('persiapan_kerja', 5, 2)->default(0);
            $table->decimal('kerjasama_team', 5, 2)->default(0);
            $table->decimal('mutu_hasil_kerja', 5, 2)->default(0);

            // --- REKAPITULASI ---
            $table->decimal('rata_rata', 5, 2)->default(0); // Nilai rata-rata keseluruhan
            $table->timestamps();
            
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa_magang')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('penilaian_magang');
    }
};

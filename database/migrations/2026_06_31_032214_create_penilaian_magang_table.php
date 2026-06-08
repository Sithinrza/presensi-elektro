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
            $table->id('id_penilaian');

            $table->foreignId('id_siswa')->constrained('siswa_magang', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_kajur')->nullable()->constrained('kajur', 'id_kajur')->onDelete('set null');

            $table->string('nomor_sertifikat', 50)->nullable();

            $table->decimal('kecakapan_kerja', 5, 2)->default(0);
            $table->decimal('menerima_perintah', 5, 2)->default(0);
            $table->decimal('sikap_perilaku', 5, 2)->default(0);
            $table->decimal('inisiatif_kreatifitas', 5, 2)->default(0);
            $table->decimal('disiplin_kehadiran', 5, 2)->default(0);
            $table->decimal('tanggung_jawab', 5, 2)->default(0);

            $table->decimal('pemahaman_teknis', 5, 2)->default(0);
            $table->decimal('persiapan_kerja', 5, 2)->default(0);
            $table->decimal('kerjasama_team', 5, 2)->default(0);
            $table->decimal('mutu_hasil_kerja', 5, 2)->default(0);

            $table->decimal('rata_rata', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_magang');
    }
};

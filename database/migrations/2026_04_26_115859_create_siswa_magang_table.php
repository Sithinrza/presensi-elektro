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
        Schema::create('siswa_magang', function (Blueprint $table) {
            $table->id('id_siswa');

            // Relasi User (Wajib) - Jika user dihapus, data siswa magang ikut terhapus
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            // Data Utama
            $table->string('nis', 50)->nullable();
            $table->string('nama_lengkap', 100);


            $table->enum('jk', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 40)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('sekolah_asal', 100)->nullable();
            $table->string('jurusan', 100)->nullable();


            $table->foreignId('id_agama')->nullable()->constrained('agama', 'id_agama');

            $table->foreignId('id_pembimbing')->nullable()->constrained('pembimbing', 'id_pembimbing')->onDelete('set null');

            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_profil')->nullable();

            // Data Penugasan Magang
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_magang');
    }
};

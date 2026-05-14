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
            $table->id('id_siswa'); // atau id() biasa, sesuaikan dengan aslinya

            // Relasi User (Wajib)
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            // Data Cangkang (Wajib)
            $table->string('nama_lengkap', 100);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');

            // ==========================================
            // DATA OPSIONAL (Diisi Siswa via Popup / Admin)
            // ==========================================

            // Data Akademik
            $table->string('nis', 50)->nullable();
            $table->string('sekolah_asal', 100)->nullable();
            $table->string('jurusan', 100)->nullable();

            // Relasi Master
            $table->unsignedBigInteger('id_agama')->nullable(); // Biarkan tanpa foreign() dulu agar aman saat migrate:fresh
            $table->unsignedBigInteger('id_pembimbing')->nullable();

            // Biodata Lengkap
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();

            // Data Penugasan Magang (Dari Admin)
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

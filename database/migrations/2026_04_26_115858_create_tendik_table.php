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
       Schema::create('tendik', function (Blueprint $table) {
            $table->id('id_tendik');

            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            $table->string('nama_lengkap', 50);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');

            $table->string('nip')->nullable()->unique();

            $table->foreignId('id_unit_kerja')->nullable()->constrained('unit_kerja', 'id_unit_kerja');
            $table->foreignId('id_agama')->nullable()->constrained('agama', 'id_agama');
            $table->foreignId('id_pend_terakhir')->nullable()->constrained('pendidikan_terakhir', 'id_pend_terakhir');
            $table->foreignId('id_pangkat_golongan')->nullable()->constrained('pangkat_golongan', 'id_pangkat_golongan');
            $table->foreignId('id_jabatan')->nullable()->constrained('jabatan', 'id_jabatan');

        
            $table->enum('jk', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 40)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_profil')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tendik');
    }
};

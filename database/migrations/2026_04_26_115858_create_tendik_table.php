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
            $table->increments('id_tendik');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_unit_kerja');
            $table->unsignedInteger('id_agama');
            $table->unsignedInteger('id_pend_terakhir');
            $table->string('nip', 50)->nullable();
            $table->string('nama_lengkap', 100);
            $table->enum('jk', ['L', 'P']);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_profil', 150)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_unit_kerja')->references('id_unit_kerja')->on('unit_kerja');
            $table->foreign('id_agama')->references('id_agama')->on('agama');
            $table->foreign('id_pend_terakhir')->references('id_pend_terakhir')->on('pend_terakhir');
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

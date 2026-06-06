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
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->id('id_pembimbing');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            $table->string('no_induk', 50)->nullable();
            $table->string('nama_lengkap', 100);
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->enum('jk', ['L', 'P'])->nullable();

            $table->foreignId('id_agama')->nullable()->constrained('agama', 'id_agama');
            $table->string('jabatan', 100)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('foto_profil')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing');
    }
};

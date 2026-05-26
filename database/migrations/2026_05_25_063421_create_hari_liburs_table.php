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
    Schema::create('hari_libur', function (Blueprint $table) {
        $table->id('id_libur');

        $table->string('nama_libur');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');

        $table->enum('kategori', ['nasional', 'cuti'])->default('nasional');

        $table->text('keterangan')->nullable();

        $table->timestamps(); // Otomatis membuat created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hari_liburs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kajur', function (Blueprint $table) {
            $table->id('id_kajur');
            $table->string('nama_lengkap', 100);
            $table->string('nip', 25)->nullable()->unique();
            $table->string('periode', 15);
            $table->boolean('status_aktif')->default(false); // siapa kajur yang menjabat sekarang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kajur');
    }
};

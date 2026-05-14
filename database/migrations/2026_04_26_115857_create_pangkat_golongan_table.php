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
        Schema::create('pangkat_golongan', function (Blueprint $table) {
            $table->id('id_pangkat_golongan');
            $table->foreignId('id_pangkat')->constrained('pangkat', 'id_pangkat')->onDelete('cascade');
            $table->foreignId('id_golongan')->constrained('golongan', 'id_golongan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pangkat_golongans');
    }
};

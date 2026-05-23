<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('id_log'); // Primary Key
            $table->unsignedBigInteger('id_user'); // Foreign Key ke tabel users
            $table->string('title', 150);
            $table->text('description');
            $table->timestamp('report_date');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('catatan_pembimbing')->nullable();
            $table->timestamps();

            // Hubungkan ke tabel users milikmu
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};

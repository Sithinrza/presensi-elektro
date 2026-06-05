<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_attachments', function (Blueprint $table) {
            $table->id('id_attachment');
            $table->unsignedBigInteger('id_log'); 
            $table->string('type', 50);
            $table->string('url_or_path', 255);
            $table->string('filename', 255);
            $table->timestamps();

            // Hubungkan ke tabel logs di atas
            $table->foreign('id_log')->references('id_log')->on('logs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_attachments');
    }
};

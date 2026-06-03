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
        Schema::create('surat_penghargaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('file_pengumuman')->nullable(); // Menyimpan path file PDF/Gambar Surat Pengumuman
            $table->string('file_insentif')->nullable();   // Menyimpan path file PDF/Gambar Surat Insentif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_penghargaans');
    }
};

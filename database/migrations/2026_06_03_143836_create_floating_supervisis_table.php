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
        Schema::create('floating_supervisis', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (role guru_supervisi)
            $table->foreignId('supervisi_id')->constrained('users')->onDelete('cascade');
            // Menghubungkan ke tabel gurus (guru yang dinilai)
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->timestamps();
            
            // Mencegah data floating ganda yang sama persis
            $table->unique(['supervisi_id', 'guru_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floating_supervisis');
    }
};

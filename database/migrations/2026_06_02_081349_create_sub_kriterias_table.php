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
        Schema::create('sub_kriterias', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel kriterias
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade'); 
            $table->string('nama_sub_kriteria'); // Contoh: Penguasaan Kelas, Kedisiplinan
            $table->integer('nilai_ideal'); // Nilai target yang harus dicapai guru (misal: 4 atau 5)
            $table->enum('jenis_faktor', ['core', 'secondary']); // Pengelompokan CF / SF untuk GAP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kriterias');
    }
};

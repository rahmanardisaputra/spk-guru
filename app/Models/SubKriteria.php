<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'kriteria_id', 
        'nama_sub_kriteria', 
        'nilai_ideal', 
        'jenis_faktor'
    ];

    // Relasi balik ke Kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
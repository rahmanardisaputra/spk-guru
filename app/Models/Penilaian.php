<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = ['guru_id', 'user_id', 'sub_kriteria_id', 'nilai_aktual'];

    // Relasi ke tabel guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // Relasi ke tabel sub kriteria
    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }

    // Relasi ke tabel user (supervisi yang memberikan penilaian)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
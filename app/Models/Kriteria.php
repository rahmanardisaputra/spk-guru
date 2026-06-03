<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = ['kode_kriteria', 'nama_kriteria', 'bobot_persen'];

    // Relasi ke Sub Kriteria
    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }
}
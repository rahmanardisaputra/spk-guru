<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPenghargaan extends Model
{
    use HasFactory;

    protected $fillable = ['guru_id', 'file_pengumuman', 'file_insentif'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
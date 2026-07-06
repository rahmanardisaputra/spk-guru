<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloatingSupervisi extends Model
{
    use HasFactory;

    protected $fillable = ['supervisi_id', 'guru_id', 'semester'];

    public function supervisi()
    {
        return $this->belongsTo(User::class, 'supervisi_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
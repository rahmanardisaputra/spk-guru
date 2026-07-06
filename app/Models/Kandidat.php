<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = ['guru_id', 'semester'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}

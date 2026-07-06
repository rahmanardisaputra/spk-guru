<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiKepsek extends Model
{
    protected $fillable = ['semester', 'is_validated', 'validated_by', 'validated_at'];

    protected $casts = [
        'is_validated' => 'boolean',
        'validated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}

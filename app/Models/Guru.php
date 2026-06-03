<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Tambahkan baris ini biar data bisa di-save
    protected $fillable = [
        'nip', 
        'nama_guru', 
        'jenis_kelamin', 
        'pendidikan_terakhir', 
        'no_hp'
    ];
}
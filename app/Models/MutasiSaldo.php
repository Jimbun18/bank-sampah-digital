<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiSaldo extends Model
{
    use HasFactory;

    // Baris ini yang menyelamatkan kita dari error Mass Assignment
    protected $guarded = ['id'];

    // Relasi balik ke tabel User (Nasabah)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Ini dia kunci pembuka gemboknya!
    // Mengizinkan semua kolom (user_id, berat, dll) diisi secara otomatis.
    protected $guarded = ['id'];

    // Relasi ke User (Nasabah)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Jenis Sampah
    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }
}
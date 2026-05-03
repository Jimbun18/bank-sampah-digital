<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // ID Nasabah
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete(); // ID Petugas yang melayani
            $table->foreignId('jenis_sampah_id')->nullable()->constrained('jenis_sampahs')->nullOnDelete(); // ID Jenis Sampah (Botol, Kertas, dll)
            $table->float('berat')->default(0); // Berat dalam satuan Kg
            $table->integer('total_harga')->default(0); // Total Rupiah
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
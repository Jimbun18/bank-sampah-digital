<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_jemputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Nasabah
            $table->foreignId('bank_sampah_id')->nullable()->constrained('bank_sampahs')->nullOnDelete(); // Bank target
            $table->string('latitude');
            $table->string('longitude');
            $table->text('alamat_lengkap');
            $table->date('tanggal_jemput');
            $table->time('jam_jemput');
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'dijadwalkan', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_jemputs');
    }
};
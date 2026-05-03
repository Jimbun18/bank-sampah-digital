<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_saldos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Nasabah
            $table->enum('tipe', ['kredit', 'debit']); // Kredit = masuk/setor, Debit = keluar/tarik
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan'); // cth: "Setor Plastik 5kg" atau "Tarik Saldo Transfer"
            $table->decimal('saldo_akhir', 12, 2); // Snapshot saldo setelah transaksi ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_saldos');
    }
};
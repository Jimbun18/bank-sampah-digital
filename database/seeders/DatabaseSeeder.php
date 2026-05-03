<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BankSampah;
use App\Models\JenisSampah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Bank Sampah Pusat
        $bankPusat = BankSampah::create([
            'nama_bank' => 'Bank Sampah Purwokerto Pusat',
            'alamat' => 'Jl. Sudirman No. 1, Purwokerto',
            'latitude' => '-7.4244',
            'longitude' => '109.2302',
        ]);

        // 2. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'admin',
        ]);

        // 3. Buat Akun Petugas
        User::create([
            'name' => 'Petugas Jaga',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
            'bank_sampah_id' => $bankPusat->id, // Ditempatkan di Bank Pusat
        ]);

        // 4. Buat Akun Nasabah Dummy
        User::create([
            'name' => 'Jim Bun',
            'email' => 'nasabah@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'nasabah',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Pahlawan, Purwokerto',
        ]);

        // 5. Buat Master Data Jenis Sampah
        $jenis_sampahs = [
            ['nama_sampah' => 'Plastik PET (Botol Bening)', 'harga_per_kg' => 3000],
            ['nama_sampah' => 'Kardus / Kertas', 'harga_per_kg' => 2000],
            ['nama_sampah' => 'Besi / Logam', 'harga_per_kg' => 5000],
        ];

        foreach ($jenis_sampahs as $sampah) {
            JenisSampah::create($sampah);
        }
    }
}
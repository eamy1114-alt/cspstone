<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rekammedis.com',
            'username' => 'admin',  // 🔥 WAJIB DIISI!
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Dokter
        User::create([
            'name' => 'dr. Baladewi',
            'email' => 'dr.baladewi@rekammedis.com',
            'username' => 'dr.baladewi',  // 🔥 WAJIB DIISI!
            'password' => Hash::make('dokter123'),
            'role' => 'dokter',
            'id_dokter' => 'DKT001',
            'poli' => 'Umum',
        ]);

        // Perawat
        User::create([
            'name' => 'Grenvy Silsilya',
            'email' => 'grenvy@rekammedis.com',
            'username' => 'grenvy',  // 🔥 WAJIB DIISI!
            'password' => Hash::make('perawat123'),
            'role' => 'perawat',
        ]);

        // Pasien
        User::create([
            'name' => 'Cristin Napitu',
            'email' => 'cristin@rekammedis.com',
            'username' => 'cristin',  // 🔥 WAJIB DIISI!
            'password' => Hash::make('pasien123'),
            'role' => 'pasien',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '2000-01-01',
        ]);
    }
}
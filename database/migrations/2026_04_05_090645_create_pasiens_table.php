<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            // Data terenkripsi AES-256
            $table->text('nama_lengkap');
            $table->text('jenis_kelamin');
            $table->text('usia');
            $table->text('berat_badan')->nullable();
            $table->text('tinggi_badan')->nullable();
            $table->text('tekanan_darah')->nullable();
            $table->text('suhu')->nullable();
            $table->text('keluhan');
            $table->text('catatan_perawat')->nullable();
            // Data tidak dienkripsi
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->foreignId('perawat_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
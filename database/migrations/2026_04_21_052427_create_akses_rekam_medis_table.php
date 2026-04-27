<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah tabel sudah ada, jika ya hapus
        Schema::dropIfExists('akses_rekam_medis');
        
        Schema::create('akses_rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'denied', 'expired'])->default('pending');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->unique(['dokter_id', 'pasien_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akses_rekam_medis');
    }
};
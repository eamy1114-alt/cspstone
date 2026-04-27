<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('perawat_id')->nullable()->constrained('users')->onDelete('set null');
            // Data terenkripsi
            $table->text('diagnosa');
            $table->text('obat');
            $table->text('alergi')->nullable();
            $table->text('rumah_sakit');
            // File
            $table->string('foto_rontgen')->nullable();
            $table->string('hasil_lab')->nullable();
            $table->date('tanggal_pemeriksaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
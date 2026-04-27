<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_vk', function (Blueprint $table) {
            $table->id();
            // Data terenkripsi
            $table->text('tanggal')->nullable();
            $table->text('nama_pasien')->nullable();
            $table->text('no_rm')->nullable();
            $table->text('status_rawat')->nullable();
            $table->text('diagnosa')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('nama_dokter')->nullable();
            $table->text('dokter_anestesi')->nullable();
            $table->text('penata_anestesi')->nullable();
            $table->text('dokter_anak')->nullable();
            $table->text('asisten_tindakan')->nullable();
            $table->text('penolong_persalinan')->nullable();
            $table->text('pemeriksaan_pa')->nullable();
            // Metadata
            $table->integer('bulan')->nullable();
            $table->integer('tahun')->nullable();
            $table->string('jenis_tindakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_vk');
    }
};
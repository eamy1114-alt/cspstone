<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class RekamMedis extends Model
{
    use Encryptable;

    protected $table = 'rekam_medis';
    
    // Daftar kolom yang akan dienkripsi AES-256
    protected $encryptable = [
        'diagnosa', 
        'obat', 
        'alergi', 
        'rumah_sakit'
    ];

    protected $fillable = [
        'pasien_id', 
        'dokter_id', 
        'perawat_id', 
        'diagnosa',
        'obat', 
        'alergi', 
        'rumah_sakit', 
        'foto_rontgen',
        'hasil_lab', 
        'tanggal_pemeriksaan'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date'
    ];

    // Relasi
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }
}
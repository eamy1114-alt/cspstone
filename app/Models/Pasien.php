<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Pasien extends Model
{
    use Encryptable;

    protected $table = 'pasiens';
    
    // Daftar kolom yang akan dienkripsi AES-256
    protected $encryptable = [
        'nama_lengkap', 
        'jenis_kelamin', 
        'usia', 
        'berat_badan',
        'tinggi_badan', 
        'tekanan_darah', 
        'suhu', 
        'keluhan', 
        'catatan_perawat',
        'no_telp',        // TAMBAHKAN no_telp ke enkripsi
        'alamat'          // TAMBAHKAN alamat ke enkripsi
    ];

    protected $fillable = [
        'nama_lengkap', 
        'jenis_kelamin', 
        'usia', 
        'berat_badan',
        'tinggi_badan', 
        'tekanan_darah', 
        'suhu', 
        'keluhan',
        'catatan_perawat', 
        'status', 
        'perawat_id', 
        'dokter_id',
        'no_telp',        // TAMBAHKAN no_telp
        'alamat',         // TAMBAHKAN alamat
        'user_id'         // TAMBAHKAN user_id
    ];

    // Relasi
    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }

    // Relasi ke User (pasien yang punya akun)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
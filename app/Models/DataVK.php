<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;
use Carbon\Carbon;

class DataVK extends Model
{
    use Encryptable;

    protected $table = 'data_vk';
    
    // Daftar kolom yang akan dienkripsi AES-256
    protected $encryptable = [
        'tanggal', 
        'nama_pasien', 
        'no_rm', 
        'status_rawat',
        'diagnosa', 
        'tindakan', 
        'nama_dokter', 
        'dokter_anestesi',
        'penata_anestesi', 
        'dokter_anak', 
        'asisten_tindakan',
        'penolong_persalinan', 
        'pemeriksaan_pa'
    ];

    protected $fillable = [
        'tanggal', 
        'nama_pasien', 
        'no_rm', 
        'status_rawat',
        'diagnosa', 
        'tindakan', 
        'pemeriksaan_pa', 
        'nama_dokter',
        'dokter_anestesi', 
        'penata_anestesi', 
        'dokter_anak',
        'asisten_tindakan', 
        'penolong_persalinan',
        'bulan', 
        'tahun', 
        'jenis_tindakan'
    ];

    // Auto set bulan & tahun sebelum menyimpan
    protected static function booted()
    {
        static::creating(function ($data) {
            if ($data->tanggal) {
                $date = Carbon::parse($data->tanggal);
                $data->bulan = $date->month;
                $data->tahun = $date->year;
            }
        });

        static::updating(function ($data) {
            if ($data->tanggal) {
                $date = Carbon::parse($data->tanggal);
                $data->bulan = $date->month;
                $data->tahun = $date->year;
            }
        });
    }

    // Helper untuk mendapatkan jenis tindakan
    public function getJenisTindakanAttribute()
    {
        $tindakan = strtolower($this->tindakan ?? '');
        if (str_contains($tindakan, 'spontan')) return 'Persalinan Spontan';
        if (str_contains($tindakan, 'kuret')) return 'Kuretase';
        if (str_contains($tindakan, 'seksio')) return 'Seksio Sesarea';
        return 'Tindakan Lainnya';
    }
}
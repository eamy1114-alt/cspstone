<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AksesRekamMedis extends Model
{
    protected $table = 'akses_rekam_medis';
    
    protected $fillable = [
        'dokter_id', 
        'pasien_id',  // SEKARANG MERUJUK KE ID DARI TABEL PASIENS
        'status',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    // Relasi ke Dokter (User)
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    // RELASI KE PASIEN (tabel pasiens, BUKAN users)
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // Helper status
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isDenied()
    {
        return $this->status === 'denied';
    }

    public function isExpired()
    {
        return $this->status === 'expired';
    }

    // Cek apakah akses masih aktif (belum expired)
    public function isActive()
    {
        return $this->status === 'approved' && 
               ($this->expired_at === null || Carbon::now()->lessThan($this->expired_at));
    }

    // Scope untuk akses yang masih aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>', Carbon::now());
            });
    }
}
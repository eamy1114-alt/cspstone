<?php

namespace App\Http\Controllers;

use App\Models\AksesRekamMedis;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AksesController extends Controller
{
    use LogsActivity;

    protected $accessDuration = 30;

    // DOKTER MINTA AKSES (mengirim ID dari tabel PASIENS)
    public function request(Request $request)
    {
        $pasienId = $request->pasien_id;  // ID dari tabel PASIENS
        
        // Hapus akses yang expired
        AksesRekamMedis::where('dokter_id', auth()->id())
            ->where('pasien_id', $pasienId)
            ->where('status', 'approved')
            ->where('expired_at', '<', Carbon::now())
            ->delete();
        
        // Cek apakah ada akses aktif (pending atau approved)
        $existingAccess = AksesRekamMedis::where('dokter_id', auth()->id())
            ->where('pasien_id', $pasienId)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>', Carbon::now());
            })
            ->first();
        
        if ($existingAccess) {
            if ($existingAccess->status == 'approved') {
                $message = 'Anda masih memiliki akses aktif untuk pasien ini.';
            } else {
                $message = 'Permintaan akses masih menunggu persetujuan pasien.';
            }
            
            if ($request->ajax()) {
                return response()->json(['message' => $message], 400);
            }
            return back()->with('error', $message);
        }
        
        // Hapus akses yang expired/denied
        AksesRekamMedis::where('dokter_id', auth()->id())
            ->where('pasien_id', $pasienId)
            ->whereIn('status', ['expired', 'denied'])
            ->delete();
        
        // Buat permintaan akses baru
        AksesRekamMedis::create([
            'dokter_id' => auth()->id(),
            'pasien_id' => $pasienId,
            'status' => 'pending'
        ]);
        
        $this->logActivity('Meminta akses ke pasien ID: ' . $pasienId);
        
        if ($request->ajax()) {
            return response()->json(['message' => 'Permintaan akses telah dikirim ke pasien.', 'success' => true]);
        }
        return back()->with('success', 'Permintaan akses telah dikirim ke pasien.');
    }

    // PASIEN SETUJUI AKSES
    public function approve($id)
    {
        $akses = AksesRekamMedis::findOrFail($id);
        $pasien = Pasien::find($akses->pasien_id);
        
        // Pastikan pasien yang menyetujui adalah pemilik akses
        if ($pasien->user_id != auth()->id()) {
            abort(403);
        }
        
        $expiredAt = Carbon::now()->addMinutes($this->accessDuration);
        
        $akses->update([
            'status' => 'approved',
            'expired_at' => $expiredAt
        ]);
        
        $this->logActivity('Menyetujui akses dokter: ' . $akses->dokter->name);
        
        return back()->with('success', 'Akses telah diberikan ke dokter. Akses akan berakhir pada ' . $expiredAt->format('d/m/Y H:i:s'));
    }

    // PASIEN TOLAK AKSES
    public function deny($id)
    {
        $akses = AksesRekamMedis::findOrFail($id);
        $pasien = Pasien::find($akses->pasien_id);
        
        if ($pasien->user_id != auth()->id()) {
            abort(403);
        }
        
        $akses->update(['status' => 'denied']);
        
        $this->logActivity('Menolak akses dokter: ' . $akses->dokter->name);
        
        return back()->with('success', 'Permintaan akses ditolak.');
    }

    // LIHAT DAFTAR AKSES DISETUJUI (DOKTER)
    public function approvedList()
    {
        $akses = AksesRekamMedis::where('dokter_id', auth()->id())
            ->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>', Carbon::now());
            })
            ->with('pasien')
            ->get();
        
        foreach ($akses as $item) {
            // Hitung sisa waktu
            if ($item->expired_at) {
                $diff = Carbon::now()->diff($item->expired_at);
                if ($diff->h > 0) {
                    $item->sisa_waktu = $diff->h . ' jam ' . $diff->i . ' menit';
                } else {
                    $item->sisa_waktu = $diff->i . ' menit';
                }
            } else {
                $item->sisa_waktu = 'Selamanya';
            }
            
            // Ambil semua rekam medis untuk pasien ini
            $item->semua_rekam_medis = RekamMedis::where('pasien_id', $item->pasien_id)
                ->with('dokter')
                ->latest()
                ->get();
        }
        
        return view('akses.approved', compact('akses'));
    }

    // AMBIL PERMINTAAN AKSES UNTUK PASIEN (AJAX)
    public function getRequests()
    {
        // Cari pasien berdasarkan user_id yang login
        $pasien = Pasien::where('user_id', auth()->id())->first();
        
        if (!$pasien) {
            return response()->json([]);
        }
        
        // Ambil semua permintaan akses untuk pasien ini
        $requests = AksesRekamMedis::where('pasien_id', $pasien->id)
            ->where('status', 'pending')
            ->with('dokter')
            ->get();
        
        return response()->json($requests);
    }
    
    /**
     * 🔥 FUNGSI LIHAT SEMUA REKAM MEDIS PASIEN (LENGKAP DENGAN FOTO RONTGEN & HASIL LAB) 🔥
     */
    public function lihatSemuaRekamMedis($pasienId)
    {
        // Menggunakan Model RekamMedis (otomatis mendekripsi data)
        $rekamMedis = RekamMedis::where('pasien_id', $pasienId)
            ->with('dokter')
            ->latest()
            ->get()
            ->map(function($item) {
                // Data otomatis didekripsi oleh trait Encryptable di Model
                return [
                    'tanggal_pemeriksaan' => $item->tanggal_pemeriksaan,
                    'diagnosa' => $item->diagnosa,
                    'obat' => $item->obat,
                    'rumah_sakit' => $item->rumah_sakit,
                    'dokter' => $item->dokter ? $item->dokter->name : null,
                    'foto_rontgen' => $item->foto_rontgen,
                    'hasil_lab' => $item->hasil_lab
                ];
            });
        
        return response()->json($rekamMedis);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    use LogsActivity;

    // Form buat keluhan baru
    public function create()
    {
        return view('keluhan.create');
    }

    // Simpan keluhan
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'riwayat_jantung' => 'nullable|string',
            'hipertensi' => 'nullable|string',
            'diabetes' => 'nullable|string',
            'alergi_obat' => 'nullable|string',
            'alergi_obat_detail' => 'nullable|string',
            'riwayat_operasi' => 'nullable|string',
            'operasi_detail' => 'nullable|string',
            'keluhan' => 'required|string',
            'lama_keluhan' => 'nullable|string',
            'perkembangan_keluhan' => 'nullable|string',
            'sudah_minum_obat' => 'nullable|string',
            'obat_diminum' => 'nullable|string',
        ]);

        // Gabungkan semua data keluhan menjadi satu teks
        $keluhanLengkap = "KELUHAN UTAMA: " . $request->keluhan . "\n";
        $keluhanLengkap .= "Lama keluhan: " . ($request->lama_keluhan ?? '-') . "\n";
        $keluhanLengkap .= "Perkembangan: " . ($request->perkembangan_keluhan ?? '-') . "\n";
        $keluhanLengkap .= "Sudah minum obat: " . ($request->sudah_minum_obat ?? '-') . "\n";
        $keluhanLengkap .= "Obat diminum: " . ($request->obat_diminum ?? '-') . "\n\n";
        
        $keluhanLengkap .= "RIWAYAT KESEHATAN:\n";
        $keluhanLengkap .= "- Riwayat Jantung: " . ($request->riwayat_jantung ?? '-') . "\n";
        $keluhanLengkap .= "- Hipertensi: " . ($request->hipertensi ?? '-') . "\n";
        $keluhanLengkap .= "- Diabetes: " . ($request->diabetes ?? '-') . "\n";
        $keluhanLengkap .= "- Alergi Obat: " . ($request->alergi_obat ?? '-');
        if ($request->alergi_obat_detail) {
            $keluhanLengkap .= " (" . $request->alergi_obat_detail . ")";
        }
        $keluhanLengkap .= "\n- Riwayat Operasi: " . ($request->riwayat_operasi ?? '-');
        if ($request->operasi_detail) {
            $keluhanLengkap .= " (" . $request->operasi_detail . ")";
        }

        // 🔥 PERBAIKAN: Cek apakah pasien dengan user_id ini sudah ada
        $pasien = Pasien::where('user_id', auth()->id())->first();

        if ($pasien) {
            // Jika sudah ada, UPDATE data yang sudah ada
            $pasien->update([
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'keluhan' => $keluhanLengkap,
                'no_telp' => $request->no_telp,           // 🔥 SIMPAN DI FIELD TERPISAH
                'alamat' => $request->alamat,             // 🔥 SIMPAN DI FIELD TERPISAH
                'catatan_perawat' => null,                // 🔥 KOSONGKAN
                'status' => 'menunggu',
            ]);
        } else {
            // Jika belum ada, BUAT baru
            $pasien = Pasien::create([
                'user_id' => auth()->id(),
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'berat_badan' => null,
                'tinggi_badan' => null,
                'tekanan_darah' => null,
                'suhu' => null,
                'keluhan' => $keluhanLengkap,
                'no_telp' => $request->no_telp,           // 🔥 SIMPAN DI FIELD TERPISAH
                'alamat' => $request->alamat,             // 🔥 SIMPAN DI FIELD TERPISAH
                'catatan_perawat' => null,                // 🔥 KOSONGKAN
                'status' => 'menunggu',
                'perawat_id' => null,
                'dokter_id' => null,
            ]);
        }

        $this->logActivity('Mengirim konsultasi online: ' . $request->nama_lengkap);

        return redirect()->route('keluhan.riwayat')
            ->with('success', 'Konsultasi berhasil dikirim! Perawat akan segera memproses.');
    }

    // Riwayat keluhan pasien
    public function riwayat()
    {
        $user = auth()->user();
        
        // Ambil riwayat berdasarkan user_id
        $riwayat = Pasien::where('user_id', $user->id)
            ->with('dokter', 'perawat')
            ->latest()
            ->get();

        return view('keluhan.riwayat', compact('riwayat'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\DataVK;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataVKController extends Controller
{
    /**
     * Menampilkan semua data VK
     */
    public function index(Request $request)
    {
        $query = DataVK::query();
        
        // Filter
        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->jenis_tindakan) {
            $query->where('jenis_tindakan', $request->jenis_tindakan);
        }
        
        $dataVK = $query->orderBy('tanggal', 'desc')->paginate(20);
        
        // Statistik
        $statistik = [
            'total' => DataVK::count(),
            'spontan' => DataVK::where('jenis_tindakan', 'Persalinan Spontan')->count(),
            'kuretase' => DataVK::where('jenis_tindakan', 'Kuretase')->count(),
            'perBulan' => DataVK::selectRaw('bulan, COUNT(*) as total')
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get()
        ];
        
        return view('data-vk.index', compact('dataVK', 'statistik'));
    }

    /**
     * Form tambah data VK
     */
    public function create()
    {
        return view('data-vk.create');
    }

    /**
     * Simpan data VK
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_pasien' => 'required|string|max:255',
            'no_rm' => 'nullable|string|max:20',
            'status_rawat' => 'nullable|string|max:50',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'nama_dokter' => 'nullable|string|max:255',
            'dokter_anestesi' => 'nullable|string|max:255',
            'penata_anestesi' => 'nullable|string|max:255',
            'dokter_anak' => 'nullable|string|max:255',
            'asisten_tindakan' => 'nullable|string',
            'penolong_persalinan' => 'nullable|string|max:255',
            'pemeriksaan_pa' => 'nullable|string',
        ]);
        
        $date = Carbon::parse($validated['tanggal']);
        $validated['bulan'] = $date->month;
        $validated['tahun'] = $date->year;
        $validated['jenis_tindakan'] = $this->getJenisTindakan($validated['tindakan']);
        
        $dataVK = DataVK::create($validated);
        
        // Log aktivitas
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menambah data VK: ' . $validated['nama_pasien'],
            'ip_address' => $request->ip(),
            'detail' => json_encode($validated)
        ]);
        
        return redirect()->route('data-vk.index')
            ->with('success', 'Data VK berhasil ditambahkan!');
    }

    /**
     * GET data untuk edit (via AJAX)
     */
    public function edit($id)
    {
        $data = DataVK::findOrFail($id);
        
        // Jika request dari AJAX
        if (request()->ajax()) {
            return response()->json([
                'id' => $data->id,
                'tanggal' => $data->tanggal,
                'nama_pasien' => $data->nama_pasien,
                'no_rm' => $data->no_rm,
                'status_rawat' => $data->status_rawat,
                'diagnosa' => $data->diagnosa,
                'tindakan' => $data->tindakan,
                'nama_dokter' => $data->nama_dokter,
                'dokter_anestesi' => $data->dokter_anestesi,
                'asisten_tindakan' => $data->asisten_tindakan,
                'penolong_persalinan' => $data->penolong_persalinan,
            ]);
        }
        
        return view('data-vk.edit', compact('data'));
    }

    /**
     * Update data VK
     */
    public function update(Request $request, $id)
    {
        $data = DataVK::findOrFail($id);
        
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_pasien' => 'required|string|max:255',
            'no_rm' => 'nullable|string|max:20',
            'status_rawat' => 'nullable|string|max:50',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'nama_dokter' => 'nullable|string|max:255',
            'dokter_anestesi' => 'nullable|string|max:255',
            'penata_anestesi' => 'nullable|string|max:255',
            'dokter_anak' => 'nullable|string|max:255',
            'asisten_tindakan' => 'nullable|string',
            'penolong_persalinan' => 'nullable|string|max:255',
            'pemeriksaan_pa' => 'nullable|string',
        ]);
        
        $date = Carbon::parse($validated['tanggal']);
        $validated['bulan'] = $date->month;
        $validated['tahun'] = $date->year;
        $validated['jenis_tindakan'] = $this->getJenisTindakan($validated['tindakan']);
        
        $oldNama = $data->nama_pasien;
        $data->update($validated);
        
        // Log aktivitas
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mengupdate data VK: ' . $oldNama . ' -> ' . $validated['nama_pasien'],
            'ip_address' => $request->ip(),
            'detail' => json_encode($validated)
        ]);
        
        return redirect()->route('data-vk.index')
            ->with('success', 'Data VK berhasil diupdate!');
    }

    /**
     * Hapus data VK
     */
    public function destroy($id)
    {
        $data = DataVK::findOrFail($id);
        $nama = $data->nama_pasien;
        $data->delete();
        
        // Log aktivitas
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus data VK: ' . $nama,
            'ip_address' => request()->ip(),
        ]);
        
        return redirect()->route('data-vk.index')
            ->with('success', 'Data VK berhasil dihapus!');
    }

    /**
     * Detail data VK
     */
    public function show($id)
    {
        $data = DataVK::findOrFail($id);
        return view('data-vk.show', compact('data'));
    }

    /**
     * Helper untuk menentukan jenis tindakan
     */
    private function getJenisTindakan($tindakan)
    {
        $tindakan = strtolower($tindakan);
        if (str_contains($tindakan, 'spontan')) return 'Persalinan Spontan';
        if (str_contains($tindakan, 'kuret')) return 'Kuretase';
        if (str_contains($tindakan, 'seksio')) return 'Seksio Sesarea';
        return 'Tindakan Lainnya';
    }
}
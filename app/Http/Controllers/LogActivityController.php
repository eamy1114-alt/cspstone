<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class LogActivityController extends Controller
{
    use LogsActivity;

    /**
     * Menampilkan semua log aktivitas
     */
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');
        
        // Filter berdasarkan user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter berdasarkan aktivitas
        if ($request->aktivitas) {
            $query->where('aktivitas', 'like', '%' . $request->aktivitas . '%');
        }
        
        // Filter berdasarkan tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        $logs = $query->orderBy('created_at', 'desc')->paginate(50);
        
        // Statistik log
        $statistik = [
            'total' => LogAktivitas::count(),
            'hari_ini' => LogAktivitas::whereDate('created_at', today())->count(),
            'minggu_ini' => LogAktivitas::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'bulan_ini' => LogAktivitas::whereMonth('created_at', now()->month)->count(),
        ];
        
        $users = User::orderBy('name')->get();
        
        return view('admin.logs', compact('logs', 'statistik', 'users'));
    }

    /**
     * Hapus semua log (Admin only)
     */
    public function clear()
    {
        $count = LogAktivitas::count();
        LogAktivitas::truncate();
        
        // Catat aktivitas clear log
        $this->logActivity('Membersihkan semua log aktivitas (' . $count . ' data)');
        
        return redirect()->route('logs.index')
            ->with('success', 'Semua log berhasil dibersihkan!');
    }

    /**
     * Hapus log berdasarkan tanggal
     */
    public function deleteByDate(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);
        
        $deleted = LogAktivitas::whereDate('created_at', $request->tanggal)->delete();
        
        $this->logActivity('Menghapus log tanggal ' . $request->tanggal . ' (' . $deleted . ' data)');
        
        return redirect()->route('logs.index')
            ->with('success', $deleted . ' log berhasil dihapus!');
    }

    /**
     * Hapus log berdasarkan user
     */
    public function deleteByUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $user = User::find($request->user_id);
        $deleted = LogAktivitas::where('user_id', $request->user_id)->delete();
        
        $this->logActivity('Menghapus log user ' . $user->name . ' (' . $deleted . ' data)');
        
        return redirect()->route('logs.index')
            ->with('success', $deleted . ' log user ' . $user->name . ' berhasil dihapus!');
    }
}
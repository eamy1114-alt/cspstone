<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Hapus user (Admin only)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        
        // Cegah menghapus admin lain (opsional)
        if ($user->role === 'admin' && auth()->user()->id !== $user->id) {
            return back()->with('error', 'Tidak bisa menghapus admin lain!');
        }
        
        $nama = $user->name;
        $role = $user->role;
        $user->delete();
        
        // Log aktivitas
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menghapus user: ' . $nama . ' (' . $role . ')',
            'ip_address' => request()->ip(),
        ]);
        
        return back()->with('success', 'User ' . $nama . ' berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Helpers\CaptchaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Catat aktivitas registrasi ke log
     */
    private function logActivity($aktivitas, $detail = null)
    {
        LogAktivitas::create([
            'user_id' => auth()->id() ?? 0,
            'aktivitas' => $aktivitas,
            'ip_address' => request()->ip(),
            'detail' => $detail ? json_encode($detail) : null
        ]);
    }

    /**
     * Register Pasien (dengan CAPTCHA)
     */
    public function storePasien(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'tanggal_lahir' => 'required|date',
            'captcha' => 'required|string'
        ]);

        // Validasi CAPTCHA
        if (!CaptchaHelper::validate($request->captcha)) {
            return back()->withErrors(['captcha' => 'Kode captcha yang Anda masukkan salah.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'tanggal_lahir' => $request->tanggal_lahir,
            'role' => 'pasien'
        ]);

        return redirect()->route('login.pasien')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Register Dokter (dengan CAPTCHA)
     */
    public function storeDokter(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_dokter' => 'required|string|unique:users',
            'poli' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'captcha' => 'required|string'
        ]);

        // Validasi CAPTCHA
        if (!CaptchaHelper::validate($request->captcha)) {
            return back()->withErrors(['captcha' => 'Kode captcha yang Anda masukkan salah.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'id_dokter' => $request->id_dokter,
            'poli' => $request->poli,
            'email' => $request->email,
            'username' => $request->id_dokter,
            'password' => Hash::make($request->password),
            'role' => 'dokter'
        ]);

        return redirect()->route('login.dokter')
            ->with('success', 'Registrasi dokter berhasil! Silakan login.');
    }

    /**
     * Register Admin (dengan CAPTCHA)
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'captcha' => 'required|string'
        ]);

        // Validasi CAPTCHA
        if (!CaptchaHelper::validate($request->captcha)) {
            return back()->withErrors(['captcha' => 'Kode captcha yang Anda masukkan salah.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        return redirect()->route('login.admin')
            ->with('success', 'Registrasi admin berhasil! Silakan login.');
    }

    /**
     * Register Perawat (dengan CAPTCHA)
     */
    public function storePerawat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_perawat' => 'required|string|unique:users,id_dokter',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'captcha' => 'required|string'
        ]);

        // Validasi CAPTCHA
        if (!CaptchaHelper::validate($request->captcha)) {
            return back()->withErrors(['captcha' => 'Kode captcha yang Anda masukkan salah.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'id_dokter' => $request->id_perawat,  // Simpan ID Perawat di kolom id_dokter
            'email' => $request->email,
            'username' => $request->id_perawat,   // Username = ID Perawat
            'password' => Hash::make($request->password),
            'role' => 'perawat',
            'poli' => null
        ]);

        return redirect()->route('login.perawat')
            ->with('success', 'Registrasi perawat berhasil! Silakan login.');
    }
}
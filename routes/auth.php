<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// ============================================
// LOGIN ROUTES
// ============================================
Route::middleware('guest')->group(function () {
    // Login Pasien
    Route::get('/login/pasien', function () {
        return view('auth.login-pasien');
    })->name('login.pasien');
    
    Route::post('/login/pasien', [LoginController::class, 'loginPasien']);
    
    // Login Dokter
    Route::get('/login/dokter', function () {
        return view('auth.login-dokter');
    })->name('login.dokter');
    
    Route::post('/login/dokter', [LoginController::class, 'loginDokter']);
    
    // Login Admin
    Route::get('/login/admin', function () {
        return view('auth.login-admin');
    })->name('login.admin');
    
    Route::post('/login/admin', [LoginController::class, 'loginAdmin']);
    
    // Register Routes
    Route::get('/register/pasien', function () {
        return view('auth.register-pasien');
    })->name('register.pasien');
    
    Route::post('/register/pasien', [RegisteredUserController::class, 'storePasien']);
    
    Route::get('/register/dokter', function () {
        return view('auth.register-dokter');
    })->name('register.dokter');
    
    Route::post('/register/dokter', [RegisteredUserController::class, 'storeDokter']);
    
    Route::get('/register/admin', function () {
        return view('auth.register-admin');
    })->name('register.admin');
    
    Route::post('/register/admin', [RegisteredUserController::class, 'storeAdmin']);
});

// ============================================
// LOGOUT ROUTE
// ============================================
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
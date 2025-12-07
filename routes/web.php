<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;      // [PENTING: Jangan lupa di-import]
use App\Http\Controllers\DashboardController; // [PENTING: Jangan lupa di-import]
use Inertia\Inertia;

// --- HALAMAN DEPAN (LANDING PAGE) ---
Route::get('/', function () {
    // Jika user sudah login, langsung arahkan ke dashboard mereka (opsional, tapi UX yang baik)
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff_gudang' => redirect()->route('gudang.dashboard'),
            'staff_armada' => redirect()->route('armada.dashboard'),
            'manajer' => redirect()->route('manajer.dashboard'),
            default => redirect('/'),
        };
    }
    return Inertia::render('Welcome'); 
})->name('home');

// --- GUEST ROUTES (KHUSUS YANG BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    // Menampilkan Halaman Login
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    
    // Memproses Data Login
    Route::post('/login', [AuthController::class, 'store']);
});

// --- AUTHENTICATED ROUTES (KHUSUS YANG SUDAH LOGIN) ---
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // DASHBOARD ROUTES (Penamaan sesuai AppLayout.vue)
    
    // 1. Admin
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // 2. Staff Gudang
    Route::get('/dashboard/gudang', function () { 
        return Inertia::render('Dashboard/Gudang'); 
    })->name('gudang.dashboard');
    
    // 3. Staff Armada
    Route::get('/dashboard/armada', function () { 
        return Inertia::render('Dashboard/Armada'); 
    })->name('armada.dashboard');
    
    // 4. Manajer Operasional
    Route::get('/dashboard/manajer', function () { 
        return Inertia::render('Dashboard/Manajer'); 
    })->name('manajer.dashboard');
});
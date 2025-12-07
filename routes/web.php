<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GudangController; // Pastikan ini ada
use Inertia\Inertia;

// --- HALAMAN DEPAN (LANDING PAGE) ---
Route::get('/', function () {
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

// --- GUEST ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});

// --- AUTH ROUTES ---
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // 1. Admin & Order
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/admin/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/admin/order/{id}', [OrderController::class, 'show'])->name('order.show');

    // 2. Staff Gudang (SUDAH DIPERBAIKI: Menggunakan Controller)
    Route::get('/dashboard/gudang', [GudangController::class, 'index'])->name('gudang.dashboard');
    Route::get('/gudang/verifikasi/{id}', [GudangController::class, 'show'])->name('gudang.show');
    Route::post('/gudang/verifikasi/{id}', [GudangController::class, 'update'])->name('gudang.update');

    // 3. Staff Armada (Masih Placeholder / Tampilan Saja)
    Route::get('/dashboard/armada', function () { 
        return Inertia::render('Dashboard/Armada'); 
    })->name('armada.dashboard');
    
    // 4. Manajer (Masih Placeholder / Tampilan Saja)
    Route::get('/dashboard/manajer', function () { 
        return Inertia::render('Dashboard/Manajer'); 
    })->name('manajer.dashboard');
});
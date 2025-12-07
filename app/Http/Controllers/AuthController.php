<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman Login
     */
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Memproses Login
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // 3. Cek Role & Redirect ke Dashboard yang Sesuai
            // (Nama route disesuaikan dengan yang ada di web.php)
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'staff_gudang' => redirect()->route('gudang.dashboard'),
                'staff_armada' => redirect()->route('armada.dashboard'),
                'manajer' => redirect()->route('manajer.dashboard'),
                default => redirect('/'),
            };
        }

        // 4. Jika Gagal Login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses Logout
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
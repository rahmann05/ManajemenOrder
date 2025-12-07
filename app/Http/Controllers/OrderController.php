<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Tampilkan Halaman Form Input Order
     */
    public function create()
    {
        return Inertia::render('Admin/Order/Create');
    }

    /**
     * Simpan Data Order ke Database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'pengirim' => 'required|string|max:255',
            'alamat_pengirim' => 'required|string',
            'penerima' => 'required|string|max:255',
            'alamat_penerima' => 'required|string',
            'jenis_pengiriman' => 'required|in:Reguler,Express,Kargo', // Pilihan statis dulu
            'total_berat' => 'required|numeric|min:0.1',
            'tanggal_order' => 'required|date',
        ]);

        // 2. Tambahkan Data Default
        $validated['status_order'] = 'menunggu_verifikasi'; // Status awal sesuai alur sistem

        // 3. Simpan ke Database
        Order::create($validated);

        // 4. Redirect kembali ke Dashboard dengan pesan sukses
        return redirect()->route('admin.dashboard');
    }
}
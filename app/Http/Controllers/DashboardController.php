<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data statistik sesuai SDD Gambar 183 (Dashboard Admin)
        $totalOrder = Order::count();
        $orderBaru = Order::where('status_order', 'menunggu_verifikasi')->count();
        // Asumsi status 'selesai' untuk order yang tuntas
        $orderSelesai = Order::where('status_order', 'selesai')->whereDate('updated_at', today())->count(); 
        // Mengambil jumlah pengiriman yang sedang jalan
        $dalamPengiriman = Pengiriman::where('status_terakhir', '!=', 'selesai')->count();

        // Mengambil 5 order terbaru untuk tabel
        $orderTerbaru = Order::latest()->take(5)->get();

        return Inertia::render('Dashboard/Admin', [
            'stats' => [
                'total_order' => $totalOrder,
                'order_baru' => $orderBaru,
                'order_selesai_hari_ini' => $orderSelesai,
                'dalam_pengiriman' => $dalamPengiriman,
            ],
            'recent_orders' => $orderTerbaru
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GudangController extends Controller
{
    public function index()
    {
        // Ambil order yang statusnya 'menunggu_validasi_dokumen'
        $antrean = Order::where('status_order', 'menunggu_validasi_dokumen')
            ->orderBy('created_at', 'asc')
            ->get();

        $stats = [
            'menunggu' => $antrean->count(),
            'selesai_hari_ini' => Order::whereDate('updated_at', today())
                ->where('status_order', '!=', 'menunggu_validasi_dokumen')
                ->count(),
        ];

        return Inertia::render('Dashboard/Gudang', [
            'antrean' => $antrean,
            'stats' => $stats
        ]);
    }

    public function show($id)
    {
        $order = Order::with('dokumen')->findOrFail($id);
        return Inertia::render('Gudang/Verifikasi', [
            'order' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
            'catatan' => 'nullable|string'
        ]);

        // Logika Update Status
        $statusBaru = ($request->status == 'terverifikasi') ? 'siap_dikirim' : 'ditolak_gudang';
        $order->update(['status_order' => $statusBaru]);

        // Update Dokumen
        if ($request->status == 'terverifikasi') {
            $order->dokumen()->update([
                'status' => 'valid',
                'verifikator_id' => auth()->id(),
                'catatan_verifikasi' => $request->catatan ?? 'Diverifikasi oleh Staff Gudang'
            ]);
        }

        return redirect()->route('gudang.dashboard');
    }
}
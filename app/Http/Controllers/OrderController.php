<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DokumenPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Order/Create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Kompleks
        $validated = $request->validate([
            // Data Logistik
            'jalur_pengiriman' => 'required|in:Laut,Udara',
            'jenis_muatan' => 'required|string', // Container/LCL
            'pengirim' => 'required|string',
            'alamat_pengirim' => 'required|string', // Origin
            'penerima' => 'required|string',
            'alamat_penerima' => 'required|string', // Destination
            'total_berat' => 'required|numeric',
            'total_volume' => 'nullable|numeric',
            'tanggal_order' => 'required|date',
            
            // Wajib Upload Dokumen Utama (Manifest/BL)
            'dokumen_utama' => 'required|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        DB::transaction(function () use ($request, $validated) {
            // 2. Generate Nomor Order Otomatis (Contoh: SML-202310-001)
            $count = Order::whereMonth('created_at', now()->month)->count() + 1;
            $noOrder = 'SML-' . now()->format('Ym') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 3. Simpan Order
            $order = Order::create([
                'nomor_order' => $noOrder,
                'tanggal_order' => $validated['tanggal_order'],
                'pengirim' => $validated['pengirim'],
                'alamat_pengirim' => $validated['alamat_pengirim'],
                'penerima' => $validated['penerima'],
                'alamat_penerima' => $validated['alamat_penerima'],
                'jalur_pengiriman' => $validated['jalur_pengiriman'],
                'jenis_muatan' => $validated['jenis_muatan'],
                'total_berat' => $validated['total_berat'],
                'total_volume' => $validated['total_volume'],
                'posisi_sekarang' => 'Processing at Origin',
                'status_order' => 'menunggu_validasi_dokumen',
            ]);

            // 4. Handle Upload File
            if ($request->hasFile('dokumen_utama')) {
                $file = $request->file('dokumen_utama');
                $path = $file->storeAs(
                    'dokumen-order/' . $order->id_order, 
                    'MANIFEST_' . $noOrder . '.' . $file->getClientOriginalExtension(), 
                    'public'
                );

                // Simpan ke tabel DokumenPengiriman
                DokumenPengiriman::create([
                    'order_id' => $order->id_order,
                    'jenis_dokumen' => 'Manifest/BL Utama',
                    'path_file' => $path,
                    'status' => 'pending'
                ]);
            }
        });

        return redirect()->route('admin.dashboard');
    }
}
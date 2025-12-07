<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DokumenPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // [PENTING] Tambahkan Log untuk debugging
use Inertia\Inertia;

class OrderController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Order/Create');
    }

    public function show($id)
    {
        $order = Order::with('dokumen')->findOrFail($id);
        return Inertia::render('Admin/Order/Show', [
            'order' => $order
        ]);
    }

    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $validated = $request->validate([
            'jalur_pengiriman' => 'required',
            'jenis_muatan' => 'required',
            'pengirim' => 'required',
            'alamat_pengirim' => 'required',
            'penerima' => 'required',
            'alamat_penerima' => 'required',
            
            // Validasi Koordinat (Nullable jika user tidak pakai map)
            'origin_lat' => 'nullable|numeric',
            'origin_lng' => 'nullable|numeric',
            'destination_lat' => 'nullable|numeric',
            'destination_lng' => 'nullable|numeric',

            'total_berat' => 'required|numeric',
            'total_volume' => 'nullable|numeric',
            'tanggal_order' => 'required|date',
            
            // Validasi Array Dokumen (Multi-file)
            'dokumen' => 'nullable|array', // Diubah jadi nullable agar tidak error jika kosong dulu
            'dokumen.*.jenis' => 'required_with:dokumen',
            'dokumen.*.file' => 'nullable|file|mimes:pdf,jpg,png,jpeg,doc|max:10240'
        ]);

        DB::transaction(function () use ($request, $validated) {
            // 2. GENERATE NOMOR ORDER (SML-YYYYMM-XXX)
            $count = Order::whereMonth('created_at', now()->month)->count() + 1;
            $noOrder = 'SML-' . now()->format('Ym') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 3. SIMPAN ORDER + KOORDINAT
            $order = Order::create([
                'nomor_order' => $noOrder,
                'tanggal_order' => $validated['tanggal_order'],
                'pengirim' => $validated['pengirim'],
                'alamat_pengirim' => $validated['alamat_pengirim'],
                
                // Simpan Koordinat
                'origin_lat' => $validated['origin_lat'] ?? null,
                'origin_lng' => $validated['origin_lng'] ?? null,
                
                'penerima' => $validated['penerima'],
                'alamat_penerima' => $validated['alamat_penerima'],
                
                // Simpan Koordinat Tujuan
                'destination_lat' => $validated['destination_lat'] ?? null,
                'destination_lng' => $validated['destination_lng'] ?? null,

                'jalur_pengiriman' => $validated['jalur_pengiriman'],
                'jenis_muatan' => $validated['jenis_muatan'],
                'total_berat' => $validated['total_berat'],
                'total_volume' => $validated['total_volume'],
                'posisi_sekarang' => 'Processing at Origin',
                'status_order' => 'menunggu_validasi_dokumen',
                
                // Set posisi tracking awal = lokasi asal
                'current_lat' => $validated['origin_lat'] ?? null,
                'current_lng' => $validated['origin_lng'] ?? null,
            ]);

            // 4. SIMPAN MULTIPLE DOKUMEN
            if ($request->has('dokumen')) {
                foreach ($request->dokumen as $index => $doc) {
                    // Cek apakah ada file fisik yang diupload
                    if (isset($doc['file']) && $doc['file'] instanceof \Illuminate\Http\UploadedFile) {
                        
                        $file = $doc['file'];
                        // Nama file unik: ORDERID_JENIS_TIMESTAMP.ext
                        $filename = strtoupper(str_replace(' ', '_', $doc['jenis'])) . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                        
                        $path = $file->storeAs(
                            'dokumen-order/' . $order->id_order, 
                            $filename, 
                            'public'
                        );

                        DokumenPengiriman::create([
                            'order_id' => $order->id_order,
                            'jenis_dokumen' => $doc['jenis'],
                            'path_file' => $path,
                            'status' => 'pending',
                            'kelengkapan_dokumen' => 'Uploaded by Admin'
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.dashboard');
    }
}
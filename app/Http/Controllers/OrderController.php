<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DokumenPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
     * Tampilkan Detail Order & Tracking
     */
    public function show($id)
    {
        // Ambil order beserta dokumen relasinya
        $order = Order::with('dokumen')->findOrFail($id);

        return Inertia::render('Admin/Order/Show', [
            'order' => $order
        ]);
    }

    /**
     * Simpan Data Order ke Database
     */
    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $validated = $request->validate([
            // 'jalur_pengiriman' TIDAK divalidasi karena default 'Laut'
            'jenis_muatan' => 'required|string',
            
            // Data Pengirim & Penerima
            'pengirim' => 'required|string',
            'alamat_pengirim' => 'required|string',
            'penerima' => 'required|string',
            'alamat_penerima' => 'required|string',
            
            // Koordinat Peta (Nullable jika tidak dipilih)
            'origin_lat' => 'nullable|numeric',
            'origin_lng' => 'nullable|numeric',
            'destination_lat' => 'nullable|numeric',
            'destination_lng' => 'nullable|numeric',

            // Data Fisik (Ton & CBM)
            'total_berat' => 'required|numeric', 
            'total_volume' => 'nullable|numeric', 
            
            'tanggal_order' => 'required|date',
            
            // Validasi Array Dokumen (Multi-file)
            'dokumen' => 'nullable|array', 
            'dokumen.*.jenis' => 'required_with:dokumen',
            // File boleh kosong saat validasi awal, dicek manual di loop
            'dokumen.*.file' => 'nullable|file|mimes:pdf,jpg,png,jpeg,doc|max:10240'
        ]);

        DB::transaction(function () use ($request, $validated) {
            // 2. GENERATE NOMOR ORDER (Format: SML-YYYYMM-XXX)
            $count = Order::whereMonth('created_at', now()->month)->count() + 1;
            $noOrder = 'SML-' . now()->format('Ym') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 3. SIMPAN ORDER
            $order = Order::create([
                'nomor_order' => $noOrder,
                'tanggal_order' => $validated['tanggal_order'],
                
                // Data Pengirim
                'pengirim' => $validated['pengirim'],
                'alamat_pengirim' => $validated['alamat_pengirim'],
                'origin_lat' => $validated['origin_lat'] ?? null,
                'origin_lng' => $validated['origin_lng'] ?? null,
                
                // Data Penerima
                'penerima' => $validated['penerima'],
                'alamat_penerima' => $validated['alamat_penerima'],
                'destination_lat' => $validated['destination_lat'] ?? null,
                'destination_lng' => $validated['destination_lng'] ?? null,

                // Spesifikasi Logistik (Hardcode Jalur Laut)
                'jalur_pengiriman' => 'Laut', 
                'jenis_muatan' => $validated['jenis_muatan'],
                'total_berat' => $validated['total_berat'],
                'total_volume' => $validated['total_volume'],
                
                // Status Awal
                'posisi_sekarang' => 'Processing at Origin',
                'status_order' => 'menunggu_validasi_dokumen',
                
                // Tracking Posisi Awal = Lokasi Asal
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
                        // str_replace agar nama file bersih dari spasi
                        $jenisBersih = strtoupper(str_replace([' ', '/', '\\'], '_', $doc['jenis']));
                        $filename = $jenisBersih . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                        
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
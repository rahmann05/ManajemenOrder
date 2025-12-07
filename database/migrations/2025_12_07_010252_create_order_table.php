<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('order', function (Blueprint $table) {
        $table->id('id_order');
        $table->string('nomor_order')->unique(); // Tracking ID (misal: SML-2025-001)
        $table->date('tanggal_order');
        
        // Data Pengirim & Penerima
        $table->string('pengirim');
        $table->text('alamat_pengirim'); // Bisa berupa Gudang Asal / Pelabuhan Asal
        $table->string('penerima');
        $table->text('alamat_penerima'); // Gudang Tujuan / Pelabuhan Tujuan
        
        // Spesifikasi Logistik
        $table->enum('jalur_pengiriman', ['Laut', 'Udara']); 
        $table->string('jenis_muatan'); // Container 20ft, 40ft, LCL, Breakbulk, Kargo Udara
        $table->float('total_berat'); // Kg / Ton
        $table->float('total_volume')->nullable(); // CBM (Penting untuk kargo laut)
        
        // Tracking & Status
        $table->string('posisi_sekarang')->default('Gudang Asal / Port of Loading');
        $table->string('status_order')->default('menunggu_validasi_dokumen'); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};

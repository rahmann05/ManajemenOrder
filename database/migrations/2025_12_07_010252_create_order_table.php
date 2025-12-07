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
        $table->string('nomor_order')->unique();
        $table->date('tanggal_order');
        
        // Data Pengirim & Penerima
        $table->string('pengirim');
        $table->text('alamat_pengirim');
        $table->string('penerima');
        $table->text('alamat_penerima');
        
        // Spesifikasi Logistik
        // [UPDATE] Default 'Laut', jadi tidak perlu diinput user lagi
        $table->string('jalur_pengiriman')->default('Laut'); 
        
        $table->string('jenis_muatan');
        
        // [UPDATE] Pakai double untuk angka desimal (Ton & CBM)
        $table->double('total_berat', 10, 2); // Contoh: 12.50 Ton
        $table->double('total_volume', 10, 2)->nullable(); // Contoh: 15.20 CBM
        
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

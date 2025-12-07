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
    // Pastikan nama tabel di sini sama dengan yang muncul di error Anda ('dokumen_pengiriman' atau 'dokumen_pengirimans')
    Schema::create('dokumen_pengiriman', function (Blueprint $table) {
        $table->id('id_dokumen');
        
        // Relasi ke tabel 'order' (bukan orders)
        $table->foreignId('order_id')->constrained('order', 'id_order')->onDelete('cascade');
        
        $table->string('jenis_dokumen'); 
        $table->string('path_file'); 
        $table->string('status')->default('pending');
        
        // [TAMBAHKAN KOLOM INI]
        $table->text('kelengkapan_dokumen')->nullable(); 
        
        $table->text('catatan_verifikasi')->nullable();
        $table->foreignId('verifikator_id')->nullable()->constrained('users'); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pengiriman');
    }
};

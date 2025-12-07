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
    Schema::create('dokumen_pengiriman', function (Blueprint $table) {
        $table->id('id_dokumen');
        $table->foreignId('order_id')->constrained('order', 'id_order')->onDelete('cascade');
        
        $table->string('jenis_dokumen'); // BL, Packing List, Invoice, Manifest
        $table->string('path_file'); // Lokasi file di server
        $table->string('status')->default('pending'); // pending, valid, invalid
        $table->text('catatan_verifikasi')->nullable();
        
        // Verifikator (Staff Gudang) boleh null dulu karena baru diinput Admin
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

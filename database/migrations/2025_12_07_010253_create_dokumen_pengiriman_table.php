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
        $table->string('nomor_resi')->unique();
        $table->text('kelengkapan_dokumen'); // Deskripsi atau checklist
        $table->string('path_dokumen'); // Lokasi file
        $table->foreignId('staff_gudang_id')->constrained('staff_gudang', 'id_staff_gudang');
        $table->string('status'); // Valid/Invalid
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

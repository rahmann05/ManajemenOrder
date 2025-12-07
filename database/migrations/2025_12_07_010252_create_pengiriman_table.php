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
    Schema::create('pengiriman', function (Blueprint $table) {
        $table->id('id_pengiriman');
        // Relasi ke Order (Penting agar tahu pengiriman ini untuk order mana)
        $table->foreignId('order_id')->constrained('order', 'id_order')->onDelete('cascade');
        
        // Relasi ke Armada & Supir (sesuai SDD)
        $table->foreignId('armada_id')->constrained('armada', 'id_armada');
        $table->foreignId('supir_id')->constrained('supir', 'id_supir');
        
        $table->string('lokasi_terakhir')->nullable();
        $table->string('status_terakhir');
        $table->date('tanggal_pengiriman')->nullable();
        $table->date('estimasi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};

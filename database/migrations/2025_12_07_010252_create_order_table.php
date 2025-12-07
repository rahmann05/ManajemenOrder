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
        $table->date('tanggal_order');
        $table->string('pengirim');
        $table->text('alamat_pengirim');
        $table->string('jenis_pengiriman');
        $table->float('total_berat'); // Float sesuai SDD
        $table->string('penerima');
        $table->text('alamat_penerima');
        $table->string('status_order'); // Menunggu, Proses, Selesai
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

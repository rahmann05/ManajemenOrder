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
    Schema::table('order', function (Blueprint $table) {
        // Koordinat Asal (Pengirim)
        $table->double('origin_lat', 15, 8)->nullable()->after('alamat_pengirim');
        $table->double('origin_lng', 15, 8)->nullable()->after('origin_lat');
        
        // Koordinat Tujuan (Penerima)
        $table->double('destination_lat', 15, 8)->nullable()->after('alamat_penerima');
        $table->double('destination_lng', 15, 8)->nullable()->after('destination_lat');

        // Tracking Posisi Kargo (Real-time update)
        // Kita simpan koordinat terakhir barang disini agar mudah ditampilkan di peta
        $table->double('current_lat', 15, 8)->nullable()->after('posisi_sekarang');
        $table->double('current_lng', 15, 8)->nullable()->after('current_lat');
    });
}

public function down(): void
{
    Schema::table('order', function (Blueprint $table) {
        $table->dropColumn(['origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'current_lat', 'current_lng']);
    });
}

    /**
     * Reverse the migrations.
     */
    
};

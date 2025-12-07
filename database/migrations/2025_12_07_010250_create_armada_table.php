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
    Schema::create('armada', function (Blueprint $table) {
        $table->id('id_armada');
        $table->string('nomor_plat')->unique();
        $table->string('jenis_kendaraan');
        $table->integer('kapasitas'); // Menggunakan Integer sesuai SDD
        $table->string('status'); // Tersedia, Terpakai, Perbaikan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armada');
    }
};

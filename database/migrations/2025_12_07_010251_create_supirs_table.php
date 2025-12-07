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
    Schema::create('supirs', function (Blueprint $table) {
        $table->id('id_supir');
        $table->string('nama_supir');
        $table->string('nomor_sim');
        $table->string('nomor_telepon');
        $table->string('status'); // Aktif/Nonaktif
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supirs');
    }
};

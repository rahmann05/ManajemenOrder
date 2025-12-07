<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // [WAJIB ADA] Definisikan nama tabel secara manual
    protected $table = 'order'; 

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'nomor_order',
        'tanggal_order',
        'pengirim',
        'alamat_pengirim',
        'origin_lat',
        'origin_lng',
        'penerima',
        'alamat_penerima',
        'destination_lat',
        'destination_lng',
        'jalur_pengiriman',
        'jenis_muatan',
        'total_berat',
        'total_volume',
        'posisi_sekarang',
        'current_lat',
        'current_lng',
        'status_order',
    ];
    // Relasi: Satu order punya BANYAK dokumen (One to Many)
    public function dokumen()
    {
        return $this->hasMany(DokumenPengiriman::class, 'order_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'order_id');
    }
}
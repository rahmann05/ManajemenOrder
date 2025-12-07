<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Pastikan nama tabel benar
    protected $table = 'order'; 
    protected $primaryKey = 'id_order';

    // PASTIKAN SEMUA KOLOM INI ADA (Jangan ada yang kurang)
    protected $fillable = [
        'nomor_order',
        'tanggal_order',
        'pengirim',
        'alamat_pengirim',
        'origin_lat', 'origin_lng', // Dari migrasi add_coordinates
        'penerima',
        'alamat_penerima',
        'destination_lat', 'destination_lng', // Dari migrasi add_coordinates
        'jalur_pengiriman',
        'jenis_muatan',
        'total_berat',
        'total_volume', // [PASTIKAN INI ADA]
        'posisi_sekarang',
        'current_lat', 'current_lng', // Dari migrasi add_coordinates
        'status_order',
    ];
    // Relasi
    public function dokumen()
    {
        return $this->hasMany(DokumenPengiriman::class, 'order_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'order_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order'; 
    protected $primaryKey = 'id_order'; 

    protected $fillable = [
        'tanggal_order',
        'pengirim',
        'alamat_pengirim',
        'jenis_pengiriman',
        'total_berat',
        'penerima',
        'alamat_penerima',
        'status_order',
    ];

    // Relasi: Satu order punya satu dokumen pengiriman
    public function dokumen()
    {
        return $this->hasOne(DokumenPengiriman::class, 'order_id');
    }

    // Relasi: Satu order bisa memiliki riwayat pengiriman
    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'order_id');
    }
}
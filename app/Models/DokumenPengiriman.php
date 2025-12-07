<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPengiriman extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pengiriman';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'order_id',
        'jenis_dokumen',       // B/L, Manifest, Invoice, dll
        'path_file',           // Lokasi penyimpanan di storage
        'status',              // pending, valid, invalid
        'catatan_verifikasi',  // Catatan jika ditolak oleh Gudang
        'verifikator_id',      // Siapa yang memvalidasi (User ID Staff Gudang)
        'kelengkapan_dokumen', // Keterangan tambahan
    ];

    // Relasi ke Order (Induk)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relasi ke User (Staff Gudang yang memvalidasi)
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}
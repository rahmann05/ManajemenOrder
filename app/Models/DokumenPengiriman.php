<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPengiriman extends Model
{
    use HasFactory;
    // TAMBAHKAN BARIS INI (PENTING!)
    protected $table = 'dokumen_pengiriman'; 
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'order_id',
        'nomor_resi',
        'kelengkapan_dokumen',
        'path_dokumen',
        'staff_gudang_id',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function verificator()
    {
        return $this->belongsTo(StaffGudang::class, 'staff_gudang_id');
    }
}
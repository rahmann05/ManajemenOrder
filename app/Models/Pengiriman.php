<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;


    protected $table = 'pengiriman'; 

    protected $primaryKey = 'id_pengiriman';

    protected $fillable = [
        'order_id',
        'armada_id',
        'supir_id',
        'lokasi_terakhir',
        'status_terakhir',
        'tanggal_pengiriman',
        'estimasi',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function armada()
    {
        return $this->belongsTo(Armada::class, 'armada_id');
    }

    public function supir()
    {
        return $this->belongsTo(Supir::class, 'supir_id');
    }
}
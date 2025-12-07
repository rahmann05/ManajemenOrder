<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffGudang extends Model
{
    use HasFactory;
    protected $table = 'staff_gudang';
    protected $primaryKey = 'id_staff_gudang';
    protected $guarded = []; // Allow all fillable

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

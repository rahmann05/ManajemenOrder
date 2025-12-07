<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffArmada extends Model
{
    use HasFactory;
    protected $table = 'staff_armada';
    protected $primaryKey = 'id_staff_armada';
    protected $guarded = []; // Allow all fillable

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

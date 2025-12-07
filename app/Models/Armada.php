<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    use HasFactory;
    protected $table = 'armada';
    protected $primaryKey = 'id_armada';
    protected $guarded = []; // Allow all fillable

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

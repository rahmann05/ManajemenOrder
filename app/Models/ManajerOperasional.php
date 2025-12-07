<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajerOperasional extends Model
{
    use HasFactory;
    protected $table = 'manajer_operasional';
    protected $primaryKey = 'id_manajer';
    protected $guarded = []; // Allow all fillable

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

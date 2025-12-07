<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role', // Pastikan ini ada
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke peran-peran
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function staffGudang()
    {
        return $this->hasOne(StaffGudang::class, 'user_id');
    }

    public function staffArmada()
    {
        return $this->hasOne(StaffArmada::class, 'user_id');
    }

    public function manajerOperasional()
    {
        return $this->hasOne(ManajerOperasional::class, 'user_id');
    }
}
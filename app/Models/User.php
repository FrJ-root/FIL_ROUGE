<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function transportCompany()
    {
        return $this->hasOne(TransportCompany::class, 'user_id');
    }

    public function traveller()
    {
        return $this->hasOne(Traveller::class, 'user_id');
    }

    public function hotel()
    {
        return $this->hasOne(Hotel::class);
    }

    public function guide()
    {
        return $this->hasOne(Guide::class, 'user_id');
    }

}
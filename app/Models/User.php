<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Services\RoleService;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'password',
        'picture',
        'email',
        'name',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function transports()
    {
        return $this->hasOne(Transport::class, 'user_id');
    }

    public function traveller()
    {
        return $this->hasOne(Traveller::class, 'user_id');
    }

    public function hotels()
    {
        return $this->hasOne(Hotel::class);
    }

    public function guides()
    {
        return $this->hasOne(Guide::class, 'user_id');
    }

    public function guide()
    {
        return $this->hasOne(Guide::class);
    }

    public function checkCustomRole(string $roleName): bool
    {
        return RoleService::hasRole($this, $roleName);
    }
    
    public function assignRole(string $roleName): bool
    {
        try {
            parent::assignRole($roleName);
            return true;
        } catch (\Exception $e) {
            return RoleService::assignRole($this, $roleName);
        }
    }
}
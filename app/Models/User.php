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
        'name',
        'email',
        'password',
        'role',
        'picture',
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

    /**
     * Check if the user has a specific role using our service
     * Renamed to avoid conflict with Spatie's hasRole method
     *
     * @param string $roleName
     * @return bool
     */
    public function checkCustomRole(string $roleName): bool
    {
        return RoleService::hasRole($this, $roleName);
    }
    
    /**
     * Assign a role to the user using our service
     * This is safe to keep as it doesn't conflict with Spatie methods
     *
     * @param string $roleName
     * @return bool
     */
    public function assignRole(string $roleName): bool
    {
        // First try using Spatie's method
        try {
            parent::assignRole($roleName);
            return true;
        } catch (\Exception $e) {
            // Fallback to our custom service
            return RoleService::assignRole($this, $roleName);
        }
    }
}
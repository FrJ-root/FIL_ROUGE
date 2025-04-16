<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Assign a role to a user
     *
     * @param User $user
     * @param string $roleName
     * @return bool
     */
    public static function assignRole(User $user, string $roleName): bool
    {
        // Try to get the role from Spatie's Role model first
        $role = Role::where('name', $roleName)->first();
        
        if ($role) {
            $user->assignRole($role);
            return true;
        }
        
        // Fallback to direct DB interaction if Spatie's Role model doesn't find it
        $roleFromDB = DB::table('roles')->where('name', $roleName)->first();
        
        if (!$roleFromDB) {
            return false;
        }
        
        // Check if the user already has this role
        $exists = DB::table('role_user')
            ->where('user_id', $user->id)
            ->where('role_id', $roleFromDB->id)
            ->exists();
            
        if ($exists) {
            return true;
        }
        
        // Assign role to the user
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $roleFromDB->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return true;
    }
    
    /**
     * Check if a user has a specific role
     *
     * @param User $user
     * @param string $roleName
     * @return bool
     */
    public static function hasRole(User $user, string $roleName): bool
    {
        // Delegate to Spatie's hasRole method when possible
        if (method_exists($user, 'hasRole')) {
            try {
                return $user->hasRole($roleName);
            } catch (\Exception $e) {
                // Fall back to DB check if there's an error
            }
        }
        
        // Fallback direct database check
        return DB::table('role_user')
            ->where('user_id', $user->id)
            ->whereExists(function ($query) use ($roleName) {
                $query->select(DB::raw(1))
                    ->from('roles')
                    ->whereRaw('roles.id = role_user.role_id')
                    ->where('roles.name', $roleName);
            })
            ->exists();
    }
}

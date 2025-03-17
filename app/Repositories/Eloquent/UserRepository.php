<?php

namespace App\Repositories\Eloquent;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new user.
     */
    public function create(array $data)
    {
        // Use Eloquent to create a user.
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

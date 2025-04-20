<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit the trip
     */
    public function edit(User $user, Trip $trip)
    {
        // Allow managers to edit any trip
        if ($user->role === 'manager') {
            return true;
        }

        // Allow the trip creator to edit
        return $trip->creator_id === $user->id;
    }
}

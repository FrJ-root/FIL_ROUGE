<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckHotelRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Use Spatie's hasRole method
        $hasRole = $user->hasRole('hotel');
        
        // If not, check if they own any hotels
        if (!$hasRole) {
            $ownsHotel = Hotel::where('user_id', $user->id)->exists();
            
            if ($ownsHotel) {
                // Use Spatie's assignRole method
                $user->assignRole('hotel');
                $hasRole = true;
            }
        }
        
        if ($hasRole) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')
            ->with('error', 'You do not have permission to access the hotel dashboard.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            
            // If user status is not valid, log them out
            if ($user->status !== 'valide') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                $statusMessage = $user->status === 'suspend' 
                    ? 'Your account has been suspended. Please contact the administrator for assistance.' 
                    : 'Your account has been blocked. Please contact the administrator for assistance.';
                
                $statusType = $user->status === 'suspend' ? 'suspend' : 'block';
                
                return redirect()->route('login')
                    ->withErrors(['status' => $statusMessage])
                    ->with('status_type', $statusType);
            }
        }
        
        return $next($request);
    }
}

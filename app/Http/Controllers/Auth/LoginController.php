<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Check if the user exists first
        $user = \App\Models\User::where('email', $request->email)->first();
        
        // Check user account status before authentication
        if ($user) {
            if ($user->status === 'suspend') {
                return back()->withInput($request->only('email'))
                    ->withErrors(['status' => 'Your account has been suspended. Please contact the administrator for assistance.'])
                    ->with('status_type', 'suspend');
            }
            
            if ($user->status === 'block') {
                return back()->withInput($request->only('email'))
                    ->withErrors(['status' => 'Your account has been blocked. Please contact the administrator for assistance.'])
                    ->with('status_type', 'block');
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if (!$user->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'User does not have the right roles.']);
            }

            // Check status again after authentication as a safety measure
            if ($user->status !== 'valide') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                $statusMessage = $user->status === 'suspend' 
                    ? 'Your account has been suspended. Please contact the administrator.' 
                    : 'Your account has been blocked. Please contact the administrator.';
                
                $statusType = $user->status === 'suspend' ? 'suspend' : 'block';
                
                return back()->withErrors(['status' => $statusMessage])
                             ->with('status_type', $statusType);
            }

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.home');
                case 'guide':
                    return redirect()->route('guide.dashboard');
                case 'hotel':
                    return redirect()->route('hotel.dashboard');
                case 'transport':
                    return redirect()->route('transport.dashboard');
                case 'traveller':
                    return redirect()->route('traveller.dashboard');
                case 'manager':
                    return redirect()->route('manager.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['role' => 'User does not have the right roles.']);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }    
}
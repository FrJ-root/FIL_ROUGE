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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if (!$user->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'User does not have the right roles.']);
            }

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.home');
                case 'guide':
                    return redirect()->route('guide.dashboard');
                case 'hotel':
                    return redirect()->route('hotel.dashboard');
                case 'transport company': // Ensure "transport company" is used here
                    return redirect()->route('transport.dashboard');
                case 'traveller':
                    return redirect()->route('traveller.dashboard');
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
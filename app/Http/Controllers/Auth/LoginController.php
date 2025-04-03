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
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'guide':
                    return redirect()->route('guide.dashboard');
                case 'hotel':
                    return redirect()->route('hotel.dashboard');
                case 'transport company':
                    return redirect()->route('transport.dashboard');
                case 'traveller':
                default:
                    return redirect()->route('traveller.dashboard');
            }
        }

        return response()->json(['error' => 'check data that you enter'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
    }
}
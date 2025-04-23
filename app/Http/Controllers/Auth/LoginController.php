<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Traveller;


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

        $user = \App\Models\User::where('email', $request->email)->first();
        
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

            $redirect = $request->input('redirect');
            $tripId = $request->input('trip_id');
            
            if ($user->role === 'traveller') {
                $traveller = Traveller::where('user_id', $user->id)->first();
                
                if ($traveller && $traveller->payment_status === 'pending' && $traveller->trip_id) {
                    return redirect()->route('traveller.trips.payment', $traveller->trip_id)
                        ->with('info', 'Please complete your payment to confirm your booking.');
                }
                
                if ($tripId) {
                    return redirect()->to(route('traveller.trips.payment', $tripId));
                } else if ($redirect) {
                    return redirect()->to($redirect);
                }
                
                return redirect()->route('traveller.dashboard');
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
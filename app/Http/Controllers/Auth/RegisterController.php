<?php

namespace App\Http\Controllers\Auth;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Traveller;
use App\Models\Transport;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    protected $redirectTo = '/login';
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:transport,traveller,admin,hotel,guide,manager'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'traveller',
            'status' => 'valide',
        ]);

        if ($user->role === 'traveller') {
            // Check if there's a trip ID in the request (from "Trip with us" button)
            $trip_id = request()->query('trip_id');
            
            if ($trip_id) {
                // Find the trip and its itinerary to complete traveller creation
                $trip = \App\Models\Trip::find($trip_id);
                
                if ($trip && $trip->itinerary) {
                    // Create traveller with the necessary fields
                    \App\Models\Traveller::create([
                        'user_id' => $user->id,
                        'trip_id' => $trip->id,
                        'itinerary_id' => $trip->itinerary->id,
                        'payment_status' => 'pending', // Set payment status to pending
                    ]);
                }
            } else {
                // If no specific trip was selected, don't create a traveller record yet
                // The user can select a trip later
            }
        } elseif ($user->role === 'guide') {
            Guide::create([
                'user_id' => $user->id,
            ]);
        } elseif ($user->role === 'hotel') {
            Hotel::create([
                'user_id' => $user->id,
            ]);
        } elseif ($user->role === 'transport') {
            Transport::create([
                'user_id' => $user->id,
            ]);
        }

        return $user;
    }

    /**
     * Handle a registration request for the application.
     */
    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // Instead of logging in the user, redirect to login page with query parameters
        $redirectUrl = $request->query('redirect');
        $tripId = $request->query('trip_id');
        
        $loginRedirect = route('login');
        
        // Add query parameters to redirect to the payment page after login
        if ($tripId) {
            $loginRedirect .= '?trip_id=' . $tripId;
            if ($redirectUrl) {
                $loginRedirect .= '&redirect=' . urlencode($redirectUrl);
            } else {
                // If no redirect URL is provided, redirect to payment page after login
                $loginRedirect .= '&redirect=' . urlencode(route('traveller.trips.payment', $tripId));
            }
        } elseif ($redirectUrl) {
            $loginRedirect .= '?redirect=' . urlencode($redirectUrl);
        }

        return redirect($loginRedirect)
            ->with('success', 'Registration successful! Please log in to continue.');
    }
}
<?php

namespace App\Http\Controllers\Auth;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
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
            'role' => ['required', 'in:transport,traveller,admin,hotel,guide,manager'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'role' => $data['role'] ?? 'traveller',
            'password' => $data['password'],
            'email' => $data['email'],
            'name' => $data['name'],
            'status' => 'valide',
        ]);

        if ($user->role === 'traveller') {
            $trip_id = request()->query('trip_id');
            
            if ($trip_id) {
                $trip = Trip::find($trip_id);
                
                if ($trip && $trip->itinerary) {
                    Traveller::create([
                        'user_id' => $user->id,
                        'trip_id' => $trip->id,
                        'itinerary_id' => $trip->itinerary->id,
                        'payment_status' => 'pending',
                    ]);
                }
            } else {}

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

    protected function register(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $redirectUrl = $request->query('redirect');
        $tripId = $request->query('trip_id');
        
        $loginRedirect = route('login');
        
        if ($tripId) {
            $loginRedirect .= '?trip_id=' . $tripId;
            if ($redirectUrl) {
                $loginRedirect .= '&redirect=' . urlencode($redirectUrl);
            } else {
                $loginRedirect .= '&redirect=' . urlencode(route('traveller.trips.payment', $tripId));
            }
        } elseif ($redirectUrl) {
            $loginRedirect .= '?redirect=' . urlencode($redirectUrl);
        }

        return redirect($loginRedirect)
            ->with('success', 'Registration successful! Please log in to continue.');
    }
}
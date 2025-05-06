<?php

namespace App\Http\Controllers\Auth;
use App\Repositories\Interfaces\TravellerRepositoryInterface;
use App\Repositories\Interfaces\TransportRepositoryInterface;
use App\Repositories\Interfaces\GuideRepositoryInterface;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $redirectTo = '/login';
    protected $userRepository;
    protected $travellerRepository;
    protected $guideRepository;
    protected $hotelRepository;
    protected $transportRepository;
    protected $tripRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TravellerRepositoryInterface $travellerRepository,
        GuideRepositoryInterface $guideRepository,
        HotelRepositoryInterface $hotelRepository,
        TransportRepositoryInterface $transportRepository,
        TripRepositoryInterface $tripRepository
    ) {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
        $this->travellerRepository = $travellerRepository;
        $this->guideRepository = $guideRepository;
        $this->hotelRepository = $hotelRepository;
        $this->transportRepository = $transportRepository;
        $this->tripRepository = $tripRepository;
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
        $user = $this->userRepository->create([
            'role' => $data['role'] ?? 'traveller',
            'password' => $data['password'],
            'email' => $data['email'],
            'name' => $data['name'],
            'status' => 'valide',
        ]);

        if ($user->role === 'traveller') {
            $trip_id = request()->query('trip_id');
            
            if ($trip_id) {
                $trip = $this->tripRepository->findById($trip_id);
                
                if ($trip && $trip->itinerary) {
                    $this->travellerRepository->create([
                        'user_id' => $user->id,
                        'trip_id' => $trip->id,
                        'itinerary_id' => $trip->itinerary->id,
                        'payment_status' => 'pending',
                    ]);
                }
            }
        } elseif ($user->role === 'guide') {
            $this->guideRepository->create([
                'user_id' => $user->id,
            ]);
        } elseif ($user->role === 'hotel') {
            $this->hotelRepository->create([
                'user_id' => $user->id,
            ]);
        } elseif ($user->role === 'transport') {
            $this->transportRepository->create([
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
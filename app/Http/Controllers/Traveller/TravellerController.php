<?php

namespace App\Http\Controllers\Traveller;

use App\Repositories\Interfaces\TravellerRepositoryInterface;
use App\Repositories\Interfaces\ItineraryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TravellerController extends Controller
{
    protected $tripRepository;
    protected $userRepository;
    protected $travellerRepository;
    protected $itineraryRepository;

    public function __construct(
        TripRepositoryInterface $tripRepository,
        UserRepositoryInterface $userRepository,
        TravellerRepositoryInterface $travellerRepository,
        ItineraryRepositoryInterface $itineraryRepository
    ) {
        $this->middleware('auth');
        $this->tripRepository = $tripRepository;
        $this->userRepository = $userRepository;
        $this->travellerRepository = $travellerRepository;
        $this->itineraryRepository = $itineraryRepository;
    }
    
    public function index()
    {
        $traveller = $this->travellerRepository->findByUserId(Auth::id());
        $upcomingTrips = [];
        $pastTrips = [];
        
        if ($traveller) {
            $upcomingTrips = $traveller->trips()->where('start_date', '>', now())->get();
            $pastTrips = $traveller->trips()->where('end_date', '<', now())->get();
        }
        
        return view('traveller.dashboard', [
            'traveller' => $traveller,
            'upcomingTrips' => $upcomingTrips,
            'pastTrips' => $pastTrips
        ]);
    }
    
    public function trips(Request $request)
    {
        $activeStatus = $request->query('status', 'all');
        
        $traveller = auth()->user()->traveller;
        $pendingPaymentTrips = collect();
        
        if (!$traveller) {
            $allTrips = collect();
        } else {
            if ($traveller->trip_id) {
                $query = $this->tripRepository->getAll()->filter(function($trip) use ($traveller, $activeStatus) {
                    if ($activeStatus === 'pending' && $traveller->payment_status === 'pending') {
                        return $trip->id === $traveller->trip_id;
                    } elseif ($activeStatus === 'completed') {
                        return $trip->id === $traveller->trip_id && 
                               $trip->end_date < now() && 
                               $traveller->payment_status === 'paid';
                    } elseif ($activeStatus === 'cancelled') {
                        return $trip->id === $traveller->trip_id && 
                               $traveller->payment_status === 'cancelled';
                    } else {
                        return $trip->id === $traveller->trip_id;
                    }
                });
                
                $allTrips = $query;
            } else {
                $allTrips = collect();
            }
            
            if ($traveller->payment_status === 'pending' && $traveller->trip_id) {
                $pendingPaymentTrips = $this->tripRepository->findById($traveller->trip_id);
                $pendingPaymentTrips = collect([$pendingPaymentTrips]);
            }
        }
        
        $pendingPayment = $pendingPaymentTrips->isNotEmpty();
        
        return view('traveller.pages.trips', compact('allTrips', 'activeStatus', 'pendingPayment', 'pendingPaymentTrips'));
    }
    
    public function checkPaymentRequired()
    {
        $traveller = auth()->user()->traveller;
        
        if ($traveller && $traveller->trip_id && $traveller->payment_status === 'pending') {
            return redirect()->route('traveller.trips.payment', $traveller->trip_id)
                ->with('info', 'Please complete your payment to confirm your trip booking.');
        }
        
        return redirect()->route('traveller.trips');
    }
    
    public function profile()
    {
        $traveller = $this->travellerRepository->findByUserId(Auth::id());
        $user = $this->userRepository->findById(Auth::id());
        
        return view('traveller.pages.profile', [
            'traveller' => $traveller,
            'user' => $user
        ]);
    }
    
    public function editProfile()
    {
        $traveller = $this->travellerRepository->findByUserId(Auth::id());
        $user = $this->userRepository->findById(Auth::id());
        
        return view('traveller.pages.edit_profile', [
            'traveller' => $traveller,
            'user' => $user
        ]);
    }
    
    public function updateProfile(Request $request)
    {
        $user = $this->userRepository->findById(Auth::id());
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'nationality' => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:50',
            'prefered_destination' => 'nullable|string|max:100',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        if ($request->hasFile('picture')) {
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            
            $path = $request->file('picture')->store('profile-pictures', 'public');
            $userData['picture'] = $path;
        }
        
        $this->userRepository->update($user->id, $userData);
        
        $traveller = $this->travellerRepository->findByUserId($user->id);
        
        if (!$traveller) {
            $traveller = $this->travellerRepository->create([
                'user_id' => $user->id,
                'nationality' => $request->nationality,
                'passport_number' => $request->passport_number,
                'prefered_destination' => $request->prefered_destination
            ]);
        } else {
            $travellerData = [
                'nationality' => $request->nationality,
                'passport_number' => $request->passport_number,
                'prefered_destination' => $request->prefered_destination
            ];
            $this->travellerRepository->update($traveller->id, $travellerData);
        }
        
        return redirect()->route('traveller.pages.profile')
            ->with('success', 'Profile updated successfully');
    }
    
    public function addTrip($tripId)
    {
        $user = $this->userRepository->findById(Auth::id());
        $trip = $this->tripRepository->findById($tripId);
        
        $traveller = $this->travellerRepository->findByUserIdAndTripId($user->id, $trip->id);
            
        if ($traveller) {
            return redirect()->back()->with('error', 'You are already on this trip!');
        }
        
        if (!$trip->itinerary) {
            $itinerary = $this->itineraryRepository->create([
                'title' => 'Trip to ' . $trip->destination,
                'description' => 'Default itinerary for ' . $trip->destination,
                'trip_id' => $trip->id
            ]);
        }
        
        $traveller = $this->travellerRepository->findByUserId($user->id);
        
        if ($traveller) {
            $this->travellerRepository->update($traveller->id, [
                'trip_id' => $trip->id,
                'itinerary_id' => $trip->itinerary->id,
                'payment_status' => 'pending'
            ]);
        } else {
            $traveller = $this->travellerRepository->create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'itinerary_id' => $trip->itinerary->id,
                'nationality' => null,
                'passport_number' => null,
                'payment_status' => 'pending'
            ]);
        }
        
        return redirect()->route('traveller.trips.payment', $trip->id)
            ->with('info', 'Please complete payment to confirm your trip booking.');
    }
    
    public function removeTrip($tripId)
    {
        $user = $this->userRepository->findById(Auth::id());
        $trip = $this->tripRepository->findById($tripId);
        
        $traveller = $this->travellerRepository->findByUserIdAndTripId($user->id, $trip->id);
            
        if (!$traveller) {
            return redirect()->back()->with('error', 'You are not registered for this trip!');
        }
        
        if ($traveller->payment_status === 'paid' && $trip->start_date <= now()->addDays(7)) {
            return redirect()->back()->with('error', 'Cannot cancel trips that start within 7 days.');
        }
        
        if ($traveller->payment_status === 'paid') {
            $this->travellerRepository->update($traveller->id, [
                'payment_status' => 'cancelled'
            ]);
            return redirect()->route('traveller.trips', ['status' => 'cancelled'])
                ->with('success', 'Trip has been cancelled. Refund processing may take 3-5 business days.');
        } else {
            $this->travellerRepository->update($traveller->id, [
                'trip_id' => null,
                'itinerary_id' => null,
                'payment_status' => null
            ]);
            return redirect()->route('traveller.trips')
                ->with('success', 'Trip removed from your profile successfully!');
        }
    }
    
    public function showPayment($tripId)
    {
        $trip = $this->tripRepository->findById($tripId);
        
        $traveller = $this->travellerRepository->findByUserId(Auth::id());
        
        if (!$traveller) {
            $traveller = $this->travellerRepository->create([
                'user_id' => Auth::id(),
                'trip_id' => $trip->id,
                'itinerary_id' => $trip->itinerary ? $trip->itinerary->id : null,
                'payment_status' => 'pending'
            ]);
        } else if ($traveller->trip_id != $trip->id) {
            $this->travellerRepository->update($traveller->id, [
                'trip_id' => $trip->id,
                'itinerary_id' => $trip->itinerary ? $trip->itinerary->id : null,
                'payment_status' => 'pending'
            ]);
        }
        
        return view('traveller.pages.payment', compact('trip'));
    }
    
    public function processPayment(Request $request, $tripId)
    {
        $request->validate([
            'card_name' => 'required',
            'card_number' => 'required',
            'expiration' => 'required',
            'cvc' => 'required'
        ]);
        
        $trip = $this->tripRepository->findById($tripId);
        
        try {
            $traveller = $this->travellerRepository->findByUserId(Auth::id());
            $this->travellerRepository->update($traveller->id, [
                'payment_status' => 'paid'
            ]);
            
            return redirect()->route('traveller.trips')
                ->with('success', 'Payment successful! You are now booked for this trip.');
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
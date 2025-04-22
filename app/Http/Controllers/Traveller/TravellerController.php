<?php

namespace App\Http\Controllers\Traveller;

use App\Models\Trip;
use App\Models\User;
use App\Models\Traveller;
use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TravellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $traveller = Traveller::where('user_id', Auth::id())->first();
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
            $query = Trip::query();
            
            if ($traveller->trip_id) {
                if ($activeStatus === 'pending') {
                    if ($traveller->payment_status === 'pending') {
                        $query->where('id', $traveller->trip_id);
                    } else {
                        return view('traveller.pages.trips', [
                            'allTrips' => collect(),
                            'activeStatus' => $activeStatus,
                            'pendingPaymentTrips' => collect(),
                            'pendingPayment' => false
                        ]);
                    }
                } elseif ($activeStatus === 'completed') {
                    $query->where('id', $traveller->trip_id)
                          ->where('end_date', '<', now())
                          ->whereHas('travellers', function($q) {
                              $q->where('payment_status', 'paid')
                                ->where('user_id', auth()->id());
                          });
                } elseif ($activeStatus === 'cancelled') {
                    $query->where('id', $traveller->trip_id)
                          ->whereHas('travellers', function($q) {
                              $q->where('payment_status', 'cancelled')
                                ->where('user_id', auth()->id());
                          });
                } else {
                    $query->where('id', $traveller->trip_id);
                }
            } else {
                return view('traveller.pages.trips', [
                    'allTrips' => collect(),
                    'activeStatus' => $activeStatus,
                    'pendingPaymentTrips' => collect(),
                    'pendingPayment' => false
                ]);
            }
            
            $allTrips = $query->get();
            
            if ($traveller->payment_status === 'pending' && $traveller->trip_id) {
                $pendingPaymentTrips = \App\Models\Trip::where('id', $traveller->trip_id)->get();
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
        $traveller = Traveller::where('user_id', Auth::id())->first();
        $user = Auth::user();
        
        return view('traveller.pages.profile', [
            'traveller' => $traveller,
            'user' => $user
        ]);
    }
    
    public function editProfile()
    {
        $traveller = Traveller::where('user_id', Auth::id())->first();
        $user = Auth::user();
        
        return view('traveller.pages.edit_profile', [
            'traveller' => $traveller,
            'user' => $user
        ]);
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
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
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->hasFile('picture')) {
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            
            $path = $request->file('picture')->store('profile-pictures', 'public');
            $user->picture = $path;
        }
        
        $user->save();
        
        $traveller = Traveller::where('user_id', $user->id)->first();
        
        if (!$traveller) {
            $traveller = new Traveller();
            $traveller->user_id = $user->id;
        }
        
        $traveller->nationality = $request->nationality;
        $traveller->passport_number = $request->passport_number;
        $traveller->prefered_destination = $request->prefered_destination;
        $traveller->save();
        
        return redirect()->route('traveller.pages.profile')
            ->with('success', 'Profile updated successfully');
    }
    
    public function addTrip(Trip $trip)
    {
        $user = Auth::user();
        
        $traveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();
            
        if ($traveller) {
            return redirect()->back()->with('error', 'You are already on this trip!');
        }
        
        if (!$trip->itinerary) {
            $itinerary = new Itinerary([
                'title' => 'Trip to ' . $trip->destination,
                'description' => 'Default itinerary for ' . $trip->destination,
            ]);
            $trip->itinerary()->save($itinerary);
        }
        
        $traveller = Traveller::where('user_id', $user->id)->first();
        
        if ($traveller) {
            $traveller->trip_id = $trip->id;
            $traveller->itinerary_id = $trip->itinerary->id;
            $traveller->payment_status = 'pending';
            $traveller->save();
        } else {
            $traveller = Traveller::create([
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
    
    public function removeTrip(Trip $trip)
    {
        $user = Auth::user();
        
        $traveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();
            
        if (!$traveller) {
            return redirect()->back()->with('error', 'You are not registered for this trip!');
        }
        
        if ($traveller->payment_status === 'paid' && $trip->start_date <= now()->addDays(7)) {
            return redirect()->back()->with('error', 'Cannot cancel trips that start within 7 days.');
        }
        
        if ($traveller->payment_status === 'paid') {
            $traveller->payment_status = 'cancelled';
            $traveller->save();
            return redirect()->route('traveller.trips', ['status' => 'cancelled'])
                ->with('success', 'Trip has been cancelled. Refund processing may take 3-5 business days.');
        } else {
            $traveller->trip_id = null;
            $traveller->itinerary_id = null;
            $traveller->payment_status = null;
            $traveller->save();
            return redirect()->route('traveller.trips')
                ->with('success', 'Trip removed from your profile successfully!');
        }
    }
    
    public function showPayment($tripId)
    {
        $trip = \App\Models\Trip::findOrFail($tripId);
        
        $traveller = auth()->user()->traveller;
        
        if (!$traveller) {
            $traveller = \App\Models\Traveller::create([
                'user_id' => auth()->id(),
                'trip_id' => $trip->id,
                'itinerary_id' => $trip->itinerary ? $trip->itinerary->id : null,
                'payment_status' => 'pending'
            ]);
        } else if ($traveller->trip_id != $trip->id) {
            $traveller->trip_id = $trip->id;
            $traveller->itinerary_id = $trip->itinerary ? $trip->itinerary->id : null;
            $traveller->payment_status = 'pending';
            $traveller->save();
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
        
        $trip = \App\Models\Trip::findOrFail($tripId);
        
        try {
            $traveller = auth()->user()->traveller;
            $traveller->payment_status = 'paid';
            $traveller->save();
            
            return redirect()->route('traveller.trips')
                ->with('success', 'Payment successful! You are now booked for this trip.');
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
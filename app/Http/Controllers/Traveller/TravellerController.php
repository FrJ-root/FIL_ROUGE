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
        $status = $request->input('status', 'all');
        $traveller = Traveller::where('user_id', Auth::id())->first();
        
        if (!$traveller) {
            return view('traveller.pages.trips', [
                'allTrips' => [],
                'upcomingTrips' => [],
                'completedTrips' => [],
                'cancelledTrips' => [],
                'pendingPaymentTrips' => [],
                'activeStatus' => $status
            ]);
        }
        
        $query = Trip::query();
        
        if ($traveller->trip_id) {
            $query->where('id', $traveller->trip_id);
        } else {
            $query->whereNull('id');
        }
        
        $allTrips = $query->get();
        
        $upcomingTrips = collect([]);
        $completedTrips = collect([]);
        $cancelledTrips = collect([]);
        $pendingPaymentTrips = collect([]);
        
        foreach ($allTrips as $trip) {
            $paymentStatus = $traveller->payment_status;
            
            if ($paymentStatus === 'pending') {
                $pendingPaymentTrips->push($trip);
            } elseif ($paymentStatus === 'cancelled') {
                $cancelledTrips->push($trip);
            } elseif ($paymentStatus === 'paid') {
                if ($trip->start_date > now()) {
                    $upcomingTrips->push($trip);
                } elseif ($trip->end_date < now()) {
                    $completedTrips->push($trip);
                }
            }
        }
        
        $displayTrips = [];
        switch ($status) {
            case 'upcoming':
                $displayTrips = $upcomingTrips;
                break;
            case 'completed':
                $displayTrips = $completedTrips;
                break;
            case 'cancelled':
                $displayTrips = $cancelledTrips;
                break;
            case 'pending':
                $displayTrips = $pendingPaymentTrips;
                break;
            default:
                $displayTrips = $allTrips;
                break;
        }
        
        return view('traveller.pages.trips', [
            'allTrips' => $displayTrips,
            'upcomingTrips' => $upcomingTrips,
            'completedTrips' => $completedTrips,
            'cancelledTrips' => $cancelledTrips,
            'pendingPaymentTrips' => $pendingPaymentTrips,
            'activeStatus' => $status
        ]);
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
    
    public function showPayment(Trip $trip)
    {
        $user = Auth::user();
        $traveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();
            
        if (!$traveller || $traveller->payment_status !== 'pending') {
            return redirect()->route('traveller.trips');
        }
        
        return view('traveller.pages.payment', [
            'trip' => $trip,
            'traveller' => $traveller
        ]);
    }
    
    public function processPayment(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $traveller = Traveller::where('user_id', $user->id)
            ->where('trip_id', $trip->id)
            ->first();
            
        if (!$traveller) {
            return redirect()->route('traveller.trips');
        }
        
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string|min:16|max:16',
            'card_holder' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|numeric|min:3',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $traveller->payment_status = 'paid';
        $traveller->save();
        
        return redirect()->route('traveller.trips', ['status' => 'upcoming'])
            ->with('success', 'Payment successful! Your trip has been confirmed.');
    }
}
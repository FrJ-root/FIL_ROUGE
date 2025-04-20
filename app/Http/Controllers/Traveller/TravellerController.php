<?php

namespace App\Http\Controllers\Traveller;

use App\Models\Trip;
use App\Models\User;
use App\Models\Traveller;
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
    
    public function trips()
    {
        $traveller = Traveller::where('user_id', Auth::id())->first();
        $allTrips = [];
        $upcomingTrips = [];
        $completedTrips = [];
        $cancelledTrips = [];
        
        if ($traveller) {
            $allTrips = $traveller->trips()->get();
            $upcomingTrips = $traveller->trips()->where('start_date', '>', now())->get();
            $completedTrips = $traveller->trips()->where('end_date', '<', now())->get();
            $cancelledTrips = $traveller->trips()->where('status', 'cancelled')->get();
        }
        
        return view('traveller.trips', [
            'allTrips' => $allTrips,
            'upcomingTrips' => $upcomingTrips,
            'completedTrips' => $completedTrips,
            'cancelledTrips' => $cancelledTrips
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
}
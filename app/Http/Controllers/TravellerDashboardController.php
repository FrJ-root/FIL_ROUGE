<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Traveller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravellerDashboardController extends Controller
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
        
        return view('traveller.profile', [
            'traveller' => $traveller,
            'user' => $user
        ]);
    }
}
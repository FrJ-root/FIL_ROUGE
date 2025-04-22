<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Trip;
use App\Models\Tag;

class DashboardController extends Controller{
    public function index(){

        $travellers = User::where('role', 'traveller')->get();
        $transports = User::where('role', 'transport')->get();
        $hotels = User::where('role', 'hotel')->get();
        $guides = User::where('role', 'guide')->get();
        $managers = User::where('role', 'manager')->get();
        
        $activeTravellers = $travellers->where('status', 'valide')->count();
        $suspendedTravellers = $travellers->where('status', 'suspend')->count();
        $deletedTravellers = $travellers->where('status', 'block')->count();
        
        $activeTransports = $transports->where('status', 'valide')->count();
        $suspendedTransports = $transports->where('status', 'suspend')->count();
        $deletedTransports = $transports->where('status', 'block')->count();
        
        $activeHotels = $hotels->where('status', 'valide')->count();
        $suspendedHotels = $hotels->where('status', 'suspend')->count();
        $deletedHotels = $hotels->where('status', 'block')->count();
        
        $activeGuides = $guides->where('status', 'valide')->count();
        $suspendedGuides = $guides->where('status', 'suspend')->count();
        $deletedGuides = $guides->where('status', 'block')->count();
        
        $activeManagers = $managers->where('status', 'valide')->count();
        $suspendedManagers = $managers->where('status', 'suspend')->count();
        $deletedManagers = $managers->where('status', 'block')->count();
        
        $totalTrips = Trip::count();
        $totalCategories = Category::count();
        $activeTags = Tag::count();
        
        return view('admin.pages.dashboard', compact(
            'activeTravellers',
            'suspendedTravellers',
            'deletedTravellers',
            'activeTransports',
            'suspendedTransports',
            'deletedTransports',
            'activeHotels',
            'suspendedHotels',
            'deletedHotels',
            'activeGuides',
            'suspendedGuides',
            'deletedGuides',
            'activeManagers',
            'suspendedManagers',
            'deletedManagers',
            'totalTrips',
            'totalCategories',
            'activeTags'
        ));
    }

    public function trips(){
        $trips = Trip::with(['travellers', 'manager'])->latest()->paginate(10);
        $managers = User::where('role', 'manager')->where('status', 'valide')->get();
        
        return view('admin.pages.trips', compact('trips', 'managers'));
    }
}
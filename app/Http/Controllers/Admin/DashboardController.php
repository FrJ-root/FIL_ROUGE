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
        $managers = User::where('role', 'manager')->get();
        $hotels = User::where('role', 'hotel')->get();
        $guides = User::where('role', 'guide')->get();
        
        $suspendedTravellers = $travellers->where('status', 'suspend')->count();
        $activeTravellers = $travellers->where('status', 'valide')->count();
        $deletedTravellers = $travellers->where('status', 'block')->count();
        
        $suspendedTransports = $transports->where('status', 'suspend')->count();
        $activeTransports = $transports->where('status', 'valide')->count();
        $deletedTransports = $transports->where('status', 'block')->count();

        $suspendedManagers = $managers->where('status', 'suspend')->count();
        $activeManagers = $managers->where('status', 'valide')->count();
        $deletedManagers = $managers->where('status', 'block')->count();
        
        $suspendedHotels = $hotels->where('status', 'suspend')->count();
        $activeHotels = $hotels->where('status', 'valide')->count();
        $deletedHotels = $hotels->where('status', 'block')->count();
        
        $suspendedGuides = $guides->where('status', 'suspend')->count();
        $activeGuides = $guides->where('status', 'valide')->count();
        $deletedGuides = $guides->where('status', 'block')->count();
        
        $totalCategories = Category::count();
        $totalTrips = Trip::count();
        $activeTags = Tag::count();
        
        return view('admin.pages.dashboard', compact(
            'suspendedTransports',
            'suspendedTravellers',
            'suspendedManagers',
            'deletedTransports',
            'deletedTravellers',
            'activeTravellers',
            'activeTransports',
            'suspendedHotels',
            'suspendedGuides',
            'deletedManagers',
            'totalCategories',
            'activeManagers',
            'deletedGuides',
            'deletedHotels',
            'activeHotels',
            'activeGuides',
            'totalTrips',
            'activeTags',
        ));
    }

    public function trips(){
        $managers = User::where('role', 'manager')->where('status', 'valide')->get();
        $trips = Trip::with(['travellers', 'manager'])->latest()->paginate(10);
        
        return view('admin.pages.trips', compact('trips', 'managers'));
    }
}
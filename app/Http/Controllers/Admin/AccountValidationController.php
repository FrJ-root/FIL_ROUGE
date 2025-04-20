<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Category;
use App\Models\Tag;

class AccountValidationController extends Controller
{
    public function index()
    {
        // Get all users by role
        $travellers = User::where('role', 'traveller')->get();
        $transports = User::where('role', 'transport')->get();
        $hotels = User::where('role', 'hotel')->get();
        $guides = User::where('role', 'guide')->get();
        $managers = User::where('role', 'manager')->get();
        $admins = User::where('role', 'admin')->get();
        
        // Get counts for dashboard display
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
        
        // Get system statistics
        $totalTrips = Trip::count();
        $totalCategories = Category::count();
        $activeTags = Tag::count();

        return view('admin.pages.account-validation', compact(
            'travellers', 
            'transports', 
            'hotels', 
            'guides',
            'managers',
            'admins',
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
    
    public function updateStatus(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:valide,suspend,block',
        ]);
        
        $user->status = $validatedData['status'];
        $user->save();

        $statusColors = [
            'valide' => 'green',
            'suspend' => 'yellow',
            'block' => 'red'
        ];
        
        return redirect()->back()
            ->with('success', "Account status updated to {$validatedData['status']}")
            ->with('status_color', $statusColors[$validatedData['status']] ?? 'gray');
    }
}
<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Trip;
use App\Models\Tag;

class AccountValidationController extends Controller
{
    public function index()
    {
        $travellers = User::where('role', 'traveller')->get();
        $transports = User::where('role', 'transport')->get();
        $managers = User::where('role', 'manager')->get();
        $hotels = User::where('role', 'hotel')->get();
        $guides = User::where('role', 'guide')->get();
        $admins = User::where('role', 'admin')->get();
        
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

        return view('admin.pages.account-validation', compact(
            'suspendedTravellers',
            'suspendedTransports',
            'deletedTravellers',
            'deletedTransports',
            'suspendedManagers',
            'activeTravellers',
            'activeTransports',
            'suspendedHotels',
            'suspendedGuides',
            'deletedManagers',
            'totalCategories',
            'activeManagers',
            'deletedHotels',
            'deletedGuides',
            'activeHotels',
            'activeGuides',
            'travellers', 
            'transports', 
            'totalTrips',
            'activeTags',
            'managers',
            'hotels', 
            'guides',
            'admins',
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
            'suspend' => 'yellow',
            'valide' => 'green',
            'block' => 'red'
        ];
        
        return redirect()->back()
            ->with('success', "Account status updated to {$validatedData['status']}")
            ->with('status_color', $statusColors[$validatedData['status']] ?? 'gray');
    }
}
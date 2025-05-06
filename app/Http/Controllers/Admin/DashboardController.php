<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $categoryRepository;
    protected $userRepository;
    protected $tripRepository;
    protected $tagRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository,UserRepositoryInterface $userRepository,TripRepositoryInterface $tripRepository,TagRepositoryInterface $tagRepository){
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->tripRepository = $tripRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index(){
        $travellers = $this->userRepository->getUsersByRole('traveller');
        $transports = $this->userRepository->getUsersByRole('transport');
        $managers = $this->userRepository->getUsersByRole('manager');
        $hotels = $this->userRepository->getUsersByRole('hotel');
        $guides = $this->userRepository->getUsersByRole('guide');
        
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
        
        $totalCategories = count($this->categoryRepository->getAll());
        $totalTrips = count($this->tripRepository->getAll());
        $activeTags = count($this->tagRepository->getAll());
        
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
        $managers = $this->userRepository->getUsersByRole('manager')->where('status', 'valide');
        $trips = $this->tripRepository->getAllPaginated();
        
        return view('admin.pages.trips', compact('trips', 'managers'));
    }

    public function updateTripStatus(Request $request, $id){
        \Log::info('Trip status update called', [
            'trip_id' => $id,
            'status' => $request->status,
            'all_data' => $request->all()
        ]);
        
        $request->validate([
            'status' => 'required|in:active,cancelled,completed,pending,suspended',
        ]);
        
        $trip = $this->tripRepository->update($id, [
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', "Trip status updated to {$request->status}");
    }

    public function assignTrip(Request $request, $id){
        $request->validate([
            'manager_id' => 'required|exists:users,id',
        ]);
        
        $trip = $this->tripRepository->update($id, [
            'manager_id' => $request->manager_id
        ]);
        
        return redirect()->back()->with('success', 'Trip assigned successfully');
    }

    public function destroyTrip($id){
        $this->tripRepository->delete($id);
        
        return redirect()->route('admin.trips')->with('success', 'Trip deleted successfully');
    }
}
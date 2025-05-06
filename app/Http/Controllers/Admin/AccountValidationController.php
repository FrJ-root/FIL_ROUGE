<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountValidationController extends Controller
{
    protected $categoryRepository;
    protected $userRepository;
    protected $tripRepository;
    protected $tagRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        UserRepositoryInterface $userRepository,
        TripRepositoryInterface $tripRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->tripRepository = $tripRepository;
        $this->tagRepository = $tagRepository;
    }
    
    public function index()
    {
        $travellers = $this->userRepository->getUsersByRole('traveller');
        $transports = $this->userRepository->getUsersByRole('transport');
        $managers = $this->userRepository->getUsersByRole('manager');
        $hotels = $this->userRepository->getUsersByRole('hotel');
        $guides = $this->userRepository->getUsersByRole('guide');
        $admins = $this->userRepository->getUsersByRole('admin');
        
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
    
    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:valide,suspend,block',
        ]);
        
        $this->userRepository->updateStatus($id, $validatedData['status']);

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
<?php

namespace App\Http\Controllers\Destination;
use App\Repositories\Interfaces\DestinationRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $destinationRepository;
    protected $categoryRepository;
    protected $tripRepository;

    public function __construct(
        DestinationRepositoryInterface $destinationRepository,
        CategoryRepositoryInterface $categoryRepository,
        TripRepositoryInterface $tripRepository
    ) {
        $this->destinationRepository = $destinationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tripRepository = $tripRepository;
    }

    public function index(){
        $featuredDestinations = $this->destinationRepository->getFeaturedDestinations();
        $allDestinations = $this->destinationRepository->getAll()->groupBy(function($destination) {
            $location = $destination->location;
            
            if (in_array($location, ['Morocco', 'Egypt', 'Kenya', 'South Africa'])) {
                return 'Africa';
            } elseif (in_array($location, ['Japan', 'China', 'Thailand', 'Indonesia', 'India'])) {
                return 'Asia';
            } elseif (in_array($location, ['France', 'Italy', 'Spain', 'Germany', 'UK'])) {
                return 'Europe';
            } elseif (in_array($location, ['USA', 'Canada', 'Mexico'])) {
                return 'North America';
            } elseif (in_array($location, ['Brazil', 'Argentina', 'Peru', 'Colombia'])) {
                return 'South America';
            } elseif (in_array($location, ['Australia', 'New Zealand'])) {
                return 'Oceania';
            } else {
                return 'Other';
            }
        });
        
        $categories = $this->categoryRepository->getFeaturedCategories();
        
        $relatedTrips = $this->tripRepository->getAll()->take(4);
        
        return view('destinations.index', compact('featuredDestinations', 'allDestinations', 'categories', 'relatedTrips'));
    }
    
    public function show($slug){
        $destination = $this->destinationRepository->findBySlug($slug);
        $relatedTrips = $this->tripRepository->getAll()->filter(function($trip) use ($destination) {
            return strpos($trip->destination, $destination->name) !== false;
        });
        
        return view('destinations.show', compact('destination', 'relatedTrips'));
    }
}
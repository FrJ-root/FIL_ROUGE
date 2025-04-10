<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Trip;


class DestinationController extends Controller
{
    public function index(){
        $featuredDestinations = Destination::where('is_featured', true)->get();
        $allDestinations = Destination::all()->groupBy(function($destination) {
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
        
        $categories = Category::where('is_featured', true)->get();
        
        $relatedTrips = Trip::take(4)->get();
        
        return view('destinations.index', compact('featuredDestinations', 'allDestinations', 'categories', 'relatedTrips'));
    }
    
    public function show($slug){
        $destination = Destination::where('slug', $slug)->firstOrFail();
        
        $relatedTrips = Trip::where('destination', 'like', '%' . $destination->name . '%')->get();
        
        return view('destinations.show', compact('destination', 'relatedTrips'));
    }
}
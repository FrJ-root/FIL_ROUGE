<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Destination;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::query();
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }
        
        if ($request->has('category')) {
            $query->where('category_id', $request->get('category'));
        }
        
        if ($request->has('destination')) {
            $query->where('destination_id', $request->get('destination'));
        }

        $featuredGuides = Trip::where('is_featured', true)->take(3)->get();
        
        $destinations = Destination::all();
        
        $guides = $query->paginate(9);
        
        return view('travel-guides.index', compact('guides', 'featuredGuides', 'destinations'));
    }
    
    public function show($slug)
    {
        $guide = Trip::where('slug', $slug)->firstOrFail();
        $relatedGuides = Trip::where('category_id', $guide->category_id)
            ->where('id', '!=', $guide->id)
            ->take(3)
            ->get();
            
        return view('travel-guides.show', compact('guide', 'relatedGuides'));
    }
}

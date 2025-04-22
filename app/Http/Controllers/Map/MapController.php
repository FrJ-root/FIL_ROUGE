<?php

namespace App\Http\Controllers\Map;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Trip;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $destinations = \App\Models\Destination::where('is_featured', true)
            ->orWhere('name', 'like', '%' . ($request->search ?? '') . '%')
            ->take(12)
            ->get();
        
        $hotels = \App\Models\Hotel::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
        
        $searchTerm = $request->search;
        
        return view('maps.index', compact('destinations', 'hotels', 'searchTerm'));
    }
}
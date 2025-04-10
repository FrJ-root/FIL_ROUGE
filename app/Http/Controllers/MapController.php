<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Trip;

class MapController extends Controller
{
    /**
     * Display the map view with destinations
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get featured destinations with valid coordinates
        $destinations = Destination::where('is_featured', true)
            ->get();

        // Get hotels with coordinates for accommodation markers
        $hotels = Hotel::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->take(10)
            ->get();

        // Get recent trips
        $trips = Trip::with(['hotels', 'travellers'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('maps.index', compact('destinations', 'hotels', 'trips'));
    }
}
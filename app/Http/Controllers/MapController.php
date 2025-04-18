<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Trip;

class MapController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('is_featured', true)
            ->get();

        $hotels = Hotel::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->take(10)
            ->get();

        $trips = Trip::with(['hotels', 'travellers'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('maps.index', compact('destinations', 'hotels', 'trips'));
    }
}
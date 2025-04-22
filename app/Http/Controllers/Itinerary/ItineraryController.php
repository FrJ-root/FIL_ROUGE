<?php

namespace App\Http\Controllers\Itinerary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Trip;

class ItineraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function update(Request $request, $tripId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $trip = Trip::findOrFail($tripId);
        
        $this->authorize('update', $trip);
        
        if ($trip->itinerary) {
            $trip->itinerary->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            $itinerary = new Itinerary([
                'title' => $request->title,
                'description' => $request->description,
            ]);
            
            $trip->itinerary()->save($itinerary);
        }
        
        return redirect()->route('trips.show', $tripId)->with('success', 'Itinerary updated successfully!');
    }
}
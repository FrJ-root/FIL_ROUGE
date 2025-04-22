<?php

namespace App\Http\Controllers\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Trip;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request, $tripId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'activity_time' => 'required',
            'description' => 'nullable|string',
        ]);
        $trip = Trip::findOrFail($tripId);
        $this->authorize('update', $trip);
        $scheduledAt = $request->activity_date . ' ' . $request->activity_time;
        $activity = new Activity([
            'name' => $request->name,
            'location' => $request->location,
            'scheduled_at' => $scheduledAt,
            'description' => $request->description,
        ]);
        
        $trip->activities()->save($activity);
        
        return redirect()->route('trips.show', $trip->id)->with('success', 'Activity added successfully!');
    }
    
    public function destroy(Activity $activity)
    {
        $this->authorize('update', $activity->trip);
        
        $tripId = $activity->trip_id;
        $activity->delete();
        return redirect()->route('trips.show', $tripId)->with('success', 'Activity deleted successfully!');
    }
}
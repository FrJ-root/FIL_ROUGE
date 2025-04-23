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
            'location' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'description' => 'nullable|string',
            'activity_time' => 'required',
        ]);
        $trip = Trip::findOrFail($tripId);
        $this->authorize('update', $trip);
        $scheduledAt = $request->activity_date . ' ' . $request->activity_time;
        $activity = new Activity([
            'name' => $request->name,
            'scheduled_at' => $scheduledAt,
            'location' => $request->location,
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
<?php

namespace App\Http\Controllers\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    protected $activityRepository;
    protected $tripRepository;
    
    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        TripRepositoryInterface $tripRepository
    ) {
        $this->middleware('auth');
        $this->activityRepository = $activityRepository;
        $this->tripRepository = $tripRepository;
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
        
        $trip = $this->tripRepository->findById($tripId);
        $this->authorize('update', $trip);
        
        $scheduledAt = $request->activity_date . ' ' . $request->activity_time;
        
        $data = [
            'trip_id' => $tripId,
            'name' => $request->name,
            'scheduled_at' => $scheduledAt,
            'location' => $request->location,
            'description' => $request->description,
        ];
        
        $this->activityRepository->create($data);
        
        return redirect()->route('trips.show', $trip->id)->with('success', 'Activity added successfully!');
    }
    
    public function destroy($id)
    {
        $activity = $this->activityRepository->findById($id);
        $trip = $this->tripRepository->findById($activity->trip_id);
        
        $this->authorize('update', $trip);
        
        $tripId = $activity->trip_id;
        $this->activityRepository->delete($id);
        
        return redirect()->route('trips.show', $tripId)->with('success', 'Activity deleted successfully!');
    }
}
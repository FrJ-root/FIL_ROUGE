<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\GuideRepositoryInterface;
use App\Models\Guide;

class GuideRepository implements GuideRepositoryInterface
{
    public function getAll()
    {
        return Guide::all();
    }

    public function findById($id)
    {
        return Guide::findOrFail($id);
    }

    public function findByUserId($userId)
    {
        return Guide::where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Guide::create($data);
    }

    public function update($id, array $data)
    {
        $guide = Guide::findOrFail($id);
        $guide->update($data);
        return $guide;
    }

    public function delete($id)
    {
        return Guide::destroy($id);
    }

    public function updateAvailability($id, $availability, $selectedDates = null)
    {
        $guide = Guide::findOrFail($id);
        $guide->availability = $availability;
        $guide->selected_dates = $selectedDates;
        $guide->save();
        return $guide;
    }

    public function getAvailableGuides()
    {
        return Guide::where('availability', 'available')->get();
    }

    public function getGuidesByTrip($tripId)
    {
        return Guide::whereHas('trips', function($query) use ($tripId) {
            $query->where('trips.id', $tripId);
        })->get();
    }

    public function attachTrip($guideId, $tripId)
    {
        $guide = Guide::findOrFail($guideId);
        return $guide->trips()->attach($tripId);
    }

    public function detachTrip($guideId, $tripId)
    {
        $guide = Guide::findOrFail($guideId);
        return $guide->trips()->detach($tripId);
    }
}

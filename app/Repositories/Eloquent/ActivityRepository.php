<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Models\Activity;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function getAll()
    {
        return Activity::all();
    }

    public function findById($id)
    {
        return Activity::findOrFail($id);
    }

    public function create(array $data)
    {
        return Activity::create($data);
    }

    public function update($id, array $data)
    {
        $activity = Activity::findOrFail($id);
        $activity->update($data);
        return $activity;
    }

    public function delete($id)
    {
        return Activity::destroy($id);
    }

    public function getActivitiesByTrip($tripId)
    {
        return Activity::where('trip_id', $tripId)->get();
    }
}

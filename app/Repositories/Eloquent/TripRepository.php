<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Models\Trip;

class TripRepository implements TripRepositoryInterface
{
    public function getAll()
    {
        return Trip::all();
    }

    public function findById($id)
    {
        return Trip::findOrFail($id);
    }

    public function create(array $data)
    {
        return Trip::create($data);
    }

    public function update($id, array $data)
    {
        $trip = Trip::findOrFail($id);
        $trip->update($data);
        return $trip;
    }

    public function delete($id)
    {
        return Trip::destroy($id);
    }

    public function getUpcomingTrips()
    {
        return Trip::where('start_date', '>', now())
                    ->where('status', 'active')
                    ->orderBy('start_date')
                    ->get();
    }

    public function getPastTrips()
    {
        return Trip::where('end_date', '<', now())
                    ->orderBy('end_date', 'desc')
                    ->get();
    }

    public function getActiveTrips()
    {
        return Trip::where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('status', 'active')
                    ->get();
    }

    public function getTripsByManager($managerId)
    {
        return Trip::where('manager_id', $managerId)->get();
    }

    public function attachCategory($tripId, $categoryId)
    {
        $trip = Trip::findOrFail($tripId);
        return $trip->categories()->attach($categoryId);
    }

    public function detachCategory($tripId, $categoryId)
    {
        $trip = Trip::findOrFail($tripId);
        return $trip->categories()->detach($categoryId);
    }

    public function attachTag($tripId, $tagId)
    {
        $trip = Trip::findOrFail($tripId);
        return $trip->tags()->attach($tagId);
    }

    public function detachTag($tripId, $tagId)
    {
        $trip = Trip::findOrFail($tripId);
        return $trip->tags()->detach($tagId);
    }

    public function getAllPaginated($perPage = 10)
    {
        return Trip::paginate($perPage);
    }
}

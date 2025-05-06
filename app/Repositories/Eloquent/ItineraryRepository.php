<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ItineraryRepositoryInterface;
use App\Models\Itinerary;

class ItineraryRepository implements ItineraryRepositoryInterface
{
    public function getAll()
    {
        return Itinerary::all();
    }

    public function findById($id)
    {
        return Itinerary::findOrFail($id);
    }

    public function findByTripId($tripId)
    {
        return Itinerary::where('trip_id', $tripId)->first();
    }

    public function create(array $data)
    {
        return Itinerary::create($data);
    }

    public function update($id, array $data)
    {
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->update($data);
        return $itinerary;
    }

    public function delete($id)
    {
        return Itinerary::destroy($id);
    }
}

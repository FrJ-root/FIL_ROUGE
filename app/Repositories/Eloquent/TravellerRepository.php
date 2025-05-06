<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TravellerRepositoryInterface;
use App\Models\Traveller;

class TravellerRepository implements TravellerRepositoryInterface
{
    public function getAll()
    {
        return Traveller::all();
    }

    public function findById($id)
    {
        return Traveller::findOrFail($id);
    }

    public function findByUserId($userId)
    {
        return Traveller::where('user_id', $userId)->first();
    }

    public function findByUserIdAndTripId($userId, $tripId)
    {
        return Traveller::where('user_id', $userId)
                       ->where('trip_id', $tripId)
                       ->first();
    }

    public function create(array $data)
    {
        return Traveller::create($data);
    }

    public function update($id, array $data)
    {
        $traveller = Traveller::findOrFail($id);
        $traveller->update($data);
        return $traveller;
    }

    public function delete($id)
    {
        return Traveller::destroy($id);
    }

    public function getTravellersByTrip($tripId)
    {
        return Traveller::where('trip_id', $tripId)->get();
    }

    public function assignTrip($travellerId, $tripId, $itineraryId = null)
    {
        $traveller = Traveller::findOrFail($travellerId);
        $traveller->trip_id = $tripId;
        $traveller->itinerary_id = $itineraryId;
        $traveller->save();
        return $traveller;
    }

    public function removeFromTrip($travellerId)
    {
        $traveller = Traveller::findOrFail($travellerId);
        $traveller->trip_id = null;
        $traveller->itinerary_id = null;
        $traveller->save();
        return $traveller;
    }

    public function updatePaymentStatus($travellerId, $status)
    {
        $traveller = Traveller::findOrFail($travellerId);
        $traveller->payment_status = $status;
        $traveller->save();
        return $traveller;
    }
}

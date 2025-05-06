<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Models\Hotel;

class HotelRepository implements HotelRepositoryInterface
{
    public function getAll()
    {
        return Hotel::all();
    }

    public function findById($id)
    {
        return Hotel::findOrFail($id);
    }

    public function findByUserId($userId)
    {
        return Hotel::where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Hotel::create($data);
    }

    public function update($id, array $data)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($data);
        return $hotel;
    }

    public function delete($id)
    {
        return Hotel::destroy($id);
    }

    public function updateAvailability($id, $availability, $selectedDates = null, $availableRooms = null)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->availability = $availability;
        $hotel->selected_dates = $selectedDates;
        if ($availableRooms !== null) {
            $hotel->available_rooms = $availableRooms;
        }
        $hotel->save();
        return $hotel;
    }

    public function getHotelsByTrip($tripId)
    {
        return Hotel::whereHas('trips', function($query) use ($tripId) {
            $query->where('trips.id', $tripId);
        })->get();
    }

    public function attachTrip($hotelId, $tripId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        return $hotel->trips()->attach($tripId);
    }

    public function detachTrip($hotelId, $tripId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        return $hotel->trips()->detach($tripId);
    }
}

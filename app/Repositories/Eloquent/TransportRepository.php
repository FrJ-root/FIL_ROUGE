<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TransportRepositoryInterface;
use App\Models\Transport;

class TransportRepository implements TransportRepositoryInterface
{
    public function getAll()
    {
        return Transport::all();
    }

    public function findById($id)
    {
        return Transport::findOrFail($id);
    }

    public function findByUserId($userId)
    {
        return Transport::where('user_id', $userId)->first();
    }

    public function create(array $data)
    {
        return Transport::create($data);
    }

    public function update($id, array $data)
    {
        $transport = Transport::findOrFail($id);
        $transport->update($data);
        return $transport;
    }

    public function delete($id)
    {
        return Transport::destroy($id);
    }

    public function getTransportsByTrip($tripId)
    {
        return Transport::whereHas('trips', function($query) use ($tripId) {
            $query->where('trips.id', $tripId);
        })->get();
    }

    public function getTransportsByType($type)
    {
        return Transport::where('transport_type', $type)->get();
    }

    public function updateAvailability($id, $availability, $selectedDates = null)
    {
        $transport = Transport::findOrFail($id);
        $transport->availability = $availability;
        $transport->selected_dates = $selectedDates;
        $transport->save();
        return $transport;
    }

    public function attachTrip($transportId, $tripId)
    {
        $transport = Transport::findOrFail($transportId);
        return $transport->trips()->attach($tripId);
    }

    public function detachTrip($transportId, $tripId)
    {
        $transport = Transport::findOrFail($transportId);
        return $transport->trips()->detach($tripId);
    }
}

<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Models\Room;

class RoomRepository implements RoomRepositoryInterface
{
    public function getAll()
    {
        return Room::all();
    }

    public function findById($id)
    {
        return Room::findOrFail($id);
    }

    public function create(array $data)
    {
        return Room::create($data);
    }

    public function update($id, array $data)
    {
        $room = Room::findOrFail($id);
        $room->update($data);
        return $room;
    }

    public function delete($id)
    {
        return Room::destroy($id);
    }

    public function getRoomsByHotel($hotelId)
    {
        return Room::where('hotel_id', $hotelId)->get();
    }

    public function getAvailableRooms($hotelId)
    {
        return Room::where('hotel_id', $hotelId)
                  ->where('is_available', true)
                  ->get();
    }
}

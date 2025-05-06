<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;

class BookingRepository implements BookingRepositoryInterface
{
    public function getAll()
    {
        return Booking::all();
    }

    public function findById($id)
    {
        return Booking::findOrFail($id);
    }

    public function create(array $data)
    {
        return Booking::create($data);
    }

    public function update($id, array $data)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($data);
        return $booking;
    }

    public function delete($id)
    {
        return Booking::destroy($id);
    }
}

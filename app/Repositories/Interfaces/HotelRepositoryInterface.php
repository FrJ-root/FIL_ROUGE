<?php
namespace App\Repositories\Interfaces;

interface HotelRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function findByUserId($userId);
    public function update($id, array $data);
    public function getHotelsByTrip($tripId);
    public function attachTrip($hotelId, $tripId);
    public function detachTrip($hotelId, $tripId);
    public function updateAvailability($id, $availability, $selectedDates = null, $availableRooms = null);
}

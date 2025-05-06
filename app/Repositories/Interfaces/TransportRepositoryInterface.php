<?php
namespace App\Repositories\Interfaces;

interface TransportRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function findByUserId($userId);
    public function update($id, array $data);
    public function getTransportsByType($type);
    public function getTransportsByTrip($tripId);
    public function attachTrip($transportId, $tripId);
    public function detachTrip($transportId, $tripId);
    public function updateAvailability($id, $availability, $selectedDates = null);
}

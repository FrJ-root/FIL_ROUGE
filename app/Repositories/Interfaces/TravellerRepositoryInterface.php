<?php
namespace App\Repositories\Interfaces;

interface TravellerRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function findByUserId($userId);
    public function update($id, array $data);
    public function getTravellersByTrip($tripId);
    public function removeFromTrip($travellerId);
    public function updatePaymentStatus($travellerId, $status);
    public function findByUserIdAndTripId($userId, $tripId);
    public function assignTrip($travellerId, $tripId, $itineraryId = null);
}

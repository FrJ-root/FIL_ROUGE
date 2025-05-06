<?php
namespace App\Repositories\Interfaces;

interface GuideRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function getAvailableGuides();
    public function findByUserId($userId);
    public function update($id, array $data);
    public function getGuidesByTrip($tripId);
    public function attachTrip($guideId, $tripId);
    public function detachTrip($guideId, $tripId);
    public function updateAvailability($id, $availability, $selectedDates = null);
}

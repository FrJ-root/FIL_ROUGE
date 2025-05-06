<?php
namespace App\Repositories\Interfaces;

interface TripRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function getPastTrips();
    public function getActiveTrips();
    public function getUpcomingTrips();
    public function create(array $data);
    public function update($id, array $data);
    public function attachTag($tripId, $tagId);
    public function detachTag($tripId, $tagId);
    public function getTripsByManager($managerId);
    public function getAllPaginated($perPage = 10);
    public function attachCategory($tripId, $categoryId);
    public function detachCategory($tripId, $categoryId);
}

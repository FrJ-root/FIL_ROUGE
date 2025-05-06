<?php
namespace App\Repositories\Interfaces;

interface ItineraryRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function findByTripId($tripId);
    public function update($id, array $data);
}

<?php
namespace App\Repositories\Interfaces;

interface ActivityRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function getActivitiesByTrip($tripId);
}

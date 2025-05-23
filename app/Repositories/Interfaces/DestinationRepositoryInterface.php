<?php
namespace App\Repositories\Interfaces;

interface DestinationRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function findBySlug($slug);
    public function create(array $data);
    public function update($id, array $data);
    public function getFeaturedDestinations();
    public function getDestinationsByLocation($location);
}

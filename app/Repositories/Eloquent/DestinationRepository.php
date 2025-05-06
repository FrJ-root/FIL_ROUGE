<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\DestinationRepositoryInterface;
use App\Models\Destination;

class DestinationRepository implements DestinationRepositoryInterface
{
    public function getAll()
    {
        return Destination::all();
    }

    public function findById($id)
    {
        return Destination::findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return Destination::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return Destination::create($data);
    }

    public function update($id, array $data)
    {
        $destination = Destination::findOrFail($id);
        $destination->update($data);
        return $destination;
    }

    public function delete($id)
    {
        return Destination::destroy($id);
    }

    public function getFeaturedDestinations()
    {
        return Destination::where('is_featured', true)->get();
    }

    public function getDestinationsByLocation($location)
    {
        return Destination::where('location', $location)->get();
    }
}

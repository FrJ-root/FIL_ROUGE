<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RoomTypeRepositoryInterface;
use App\Models\RoomType;

class RoomTypeRepository implements RoomTypeRepositoryInterface
{
    public function getAll()
    {
        return RoomType::all();
    }

    public function findById($id)
    {
        return RoomType::findOrFail($id);
    }

    public function create(array $data)
    {
        return RoomType::create($data);
    }

    public function update($id, array $data)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->update($data);
        return $roomType;
    }

    public function delete($id)
    {
        return RoomType::destroy($id);
    }
}

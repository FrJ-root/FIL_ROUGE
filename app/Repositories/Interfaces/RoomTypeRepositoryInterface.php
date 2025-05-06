<?php
namespace App\Repositories\Interfaces;

interface RoomTypeRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
}

<?php
namespace App\Repositories\Interfaces;

interface RoomRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function getRoomsByHotel($hotelId);
    public function getAvailableRooms($hotelId);
}

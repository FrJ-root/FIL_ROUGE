<?php
namespace App\Repositories\Interfaces;

interface ReviewRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function getReviewsByGuide($guideId);
    public function getReviewsByHotel($hotelId);
}

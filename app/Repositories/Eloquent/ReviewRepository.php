<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Models\Review;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getAll()
    {
        return Review::all();
    }

    public function findById($id)
    {
        return Review::findOrFail($id);
    }

    public function create(array $data)
    {
        return Review::create($data);
    }

    public function update($id, array $data)
    {
        $review = Review::findOrFail($id);
        $review->update($data);
        return $review;
    }

    public function delete($id)
    {
        return Review::destroy($id);
    }

    public function getReviewsByGuide($guideId)
    {
        return Review::where('guide_id', $guideId)->get();
    }

    public function getReviewsByHotel($hotelId)
    {
        return Review::where('hotel_id', $hotelId)->get();
    }
}

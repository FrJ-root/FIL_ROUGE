<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transport;
use App\Models\Category;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Trip;
use App\Models\Tag;

class TripRelationshipsSeeder extends Seeder
{
    public function run()
    {
        $trips = Trip::all();
        
        if ($trips->isEmpty()) {
            return;
        }
        
        $tags = Tag::all();
        $guides = Guide::all();
        $hotels = Hotel::all();
        $categories = Category::all();
        $transports = Transport::all();
        
        if ($categories->isEmpty() || $tags->isEmpty() || $guides->isEmpty() || 
            $hotels->isEmpty() || $transports->isEmpty()) {
            return;
        }
        
        foreach ($trips as $trip) {

            $categoryCount = min(2, $categories->count());
            $tripCategories = $categories->random(rand(1, $categoryCount));
            $trip->categories()->attach($tripCategories->pluck('id')->toArray());
            
            $tagCount = min(5, $tags->count());
            $tripTags = $tags->random(rand(min(3, $tagCount), $tagCount));
            $trip->tags()->attach($tripTags->pluck('id')->toArray());
            
            $tripGuide = $guides->random(min(1, $guides->count()));
            $trip->guides()->attach($tripGuide->pluck('id')->toArray());
            
            $tripHotel = $hotels->random(min(1, $hotels->count()));
            $trip->hotels()->attach($tripHotel->pluck('id')->toArray());
            
            $tripTransport = $transports->random(min(1, $transports->count()));
            $trip->transports()->attach($tripTransport->pluck('id')->toArray());
        }
    }
}
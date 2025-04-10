<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\TransportCompany;
use Illuminate\Database\Seeder;

class TripRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trips = Trip::all();
        
        if ($trips->isEmpty()) {
            return;
        }
        
        $categories = Category::all();
        $tags = Tag::all();
        $guides = Guide::all();
        $hotels = Hotel::all();
        $transportCompanies = TransportCompany::all();
        
        // Check if the necessary relationships exist
        if ($categories->isEmpty() || $tags->isEmpty() || $guides->isEmpty() || 
            $hotels->isEmpty() || $transportCompanies->isEmpty()) {
            return;
        }
        
        foreach ($trips as $trip) {
            // Assign 1-2 categories to each trip
            $categoryCount = min(2, $categories->count());
            $tripCategories = $categories->random(rand(1, $categoryCount));
            $trip->categories()->attach($tripCategories->pluck('id')->toArray());
            
            // Assign 3-5 tags to each trip
            $tagCount = min(5, $tags->count());
            $tripTags = $tags->random(rand(min(3, $tagCount), $tagCount));
            $trip->tags()->attach($tripTags->pluck('id')->toArray());
            
            // Assign 1 guide to each trip
            $tripGuide = $guides->random(min(1, $guides->count()));
            $trip->guides()->attach($tripGuide->pluck('id')->toArray());
            
            // Assign 1 hotel to each trip
            $tripHotel = $hotels->random(min(1, $hotels->count()));
            $trip->hotels()->attach($tripHotel->pluck('id')->toArray());
            
            // Assign 1 transport company to each trip
            $tripTransport = $transportCompanies->random(min(1, $transportCompanies->count()));
            $trip->transportCompanies()->attach($tripTransport->pluck('id')->toArray());
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // First seed the independent tables
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            DestinationSeeder::class,
        ]);
        
        // Then seed the dependent tables
        $this->call([
            HotelSeeder::class,
            GuideSeeder::class,
            TransportCompanySeeder::class,
            TripSeeder::class,
        ]);
        
        // Then seed the tables that depend on trips
        $this->call([
            ItinerarySeeder::class,
            ActivitySeeder::class,
            // Include TravellerSeeder since it depends on User, Trip, and Itinerary
            TravellerSeeder::class,
        ]);
        
        // Finally seed the relationship tables
        $this->call([
            TripRelationshipsSeeder::class,
        ]);
    }
}
<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            TagSeeder::class,
            UserSeeder::class,
            TripSeeder::class,
            HotelSeeder::class,
            GuideSeeder::class,
            CategorySeeder::class,
            ActivitySeeder::class,
            ItinerarySeeder::class,
            TransportSeeder::class,
            TravellerSeeder::class,
            DestinationSeeder::class,
            TripRelationshipsSeeder::class,
            RoomTypeSeeder::class
        ]);
    }
}
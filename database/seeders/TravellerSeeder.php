<?php

namespace Database\Seeders;

use App\Models\Traveller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Itinerary;
use Illuminate\Database\Seeder;

class TravellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get traveller users
        $travellerUsers = User::where('role', 'traveller')->get();
        
        if ($travellerUsers->isEmpty()) {
            // If no traveller users, create at least one
            $user = User::create([
                'name' => 'Sample Traveller',
                'email' => 'traveller@example.com', 
                'password' => 'password',
                'role' => 'traveller'
            ]);
            $travellerUsers = collect([$user]);
        }
        
        // Get trips with their itineraries
        $trips = Trip::with('itinerary')->get();
        
        if ($trips->isEmpty()) {
            // If no trips exist, we can't create travellers linked to trips
            return;
        }
        
        // Filter trips to only include those with itineraries
        $tripsWithItineraries = $trips->filter(function($trip) {
            return $trip->itinerary !== null;
        });
        
        if ($tripsWithItineraries->isEmpty()) {
            return;
        }
        
        $nationalities = ['American', 'British', 'French', 'German', 'Japanese', 'Chinese', 'Canadian', 'Australian'];
        $preferedDestinations = ['Paris', 'New York', 'Tokyo', 'Bali', 'Marrakech', 'Cape Town', 'Rio de Janeiro', 'Sydney'];
        
        foreach ($travellerUsers as $index => $user) {
            // Assign each traveller user to a trip
            $trip = $tripsWithItineraries[$index % count($tripsWithItineraries)];
            
            Traveller::create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
                'itinerary_id' => $trip->itinerary->id,
                'nationality' => $nationalities[$index % count($nationalities)],
                'passport_number' => 'P' . str_pad(rand(1000, 9999), 6, '0', STR_PAD_LEFT),
                'prefered_destination' => $preferedDestinations[$index % count($preferedDestinations)],
            ]);
        }
    }
}

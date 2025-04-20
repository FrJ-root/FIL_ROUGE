<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Traveller;
use App\Models\Trip;
use App\Models\User;

class TravellerSeeder extends Seeder
{
    public function run()
    {
        $travellerUsers = User::where('role', 'traveller')->get();
        
        if ($travellerUsers->isEmpty()) {
            $user = User::create([
                'email' => 'traveller@example.com', 
                'name' => 'Sample Traveller',
                'password' => 'password',
                'role' => 'traveller'
            ]);
            $travellerUsers = collect([$user]);
        }
        
        $trips = Trip::with('itinerary')->get();
        
        if ($trips->isEmpty()) {
            return;
        }
        
        $tripsWithItineraries = $trips->filter(function($trip) {
            return $trip->itinerary !== null;
        });
        
        if ($tripsWithItineraries->isEmpty()) {
            return;
        }
        
        $nationalities = ['American', 'British', 'French', 'German', 'Japanese', 'Chinese', 'Canadian', 'Australian'];
        $preferedDestinations = ['Paris', 'New York', 'Tokyo', 'Bali', 'Marrakech', 'Cape Town', 'Rio de Janeiro', 'Sydney'];
        
        foreach ($travellerUsers as $index => $user) {
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

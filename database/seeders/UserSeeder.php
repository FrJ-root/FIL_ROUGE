<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Traveller;
use App\Models\Transport;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Trip;
use App\Models\Itinerary;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'role' => 'admin',
            'status' => 'valide',
        ]);

        User::create([
            'name' => 'Trip Manager',
            'email' => 'manager@manager.com',
            'password' => 'manager123',
            'role' => 'manager',
            'status' => 'valide',
        ]);

        $trip = Trip::create([
            'destination' => 'Morocco Explorer',
            'start_date' => now()->addMonth(),
            'end_date' => now()->addMonth()->addDays(10),
        ]);
        
        $itinerary = Itinerary::create([
            'trip_id' => $trip->id,
            'title' => 'Morocco Adventure',
            'description' => 'Explore the beautiful landscapes of Morocco'
        ]);

        $traveller = User::create([
            'name' => 'Traveller User',
            'email' => 'traveller@traveller.com',
            'password' => 'traveller123',
            'role' => 'traveller',
            'status' => 'valide',
        ]);

        Traveller::create([
            'user_id' => $traveller->id,
            'trip_id' => $trip->id,
            'itinerary_id' => $itinerary->id,
            'prefered_destination' => 'Morocco',
            'nationality' => 'United States',
        ]);

        $guide = User::create([
            'name' => 'Guide User',
            'email' => 'guide@guide.com',
            'password' => 'guide123',
            'role' => 'guide',
            'status' => 'valide',
        ]);

        Guide::create([
            'user_id' => $guide->id,
            'license_number' => 'G12345',
            'specialization' => 'Desert Tours',
            'preferred_locations' => 'Marrakech, Fes, Sahara',
        ]);

        $hotel = User::create([
            'name' => 'Hotel User',
            'email' => 'hotel@hotel.com',
            'password' => 'hotel123',
            'role' => 'hotel',
            'status' => 'valide',
        ]);

        Hotel::create([
            'user_id' => $hotel->id,
            'name' => 'Royal Mirage Resort',
            'description' => 'Luxury hotel with stunning views',
            'address' => '123 Beach Avenue',
            'city' => 'Agadir',
            'country' => 'Morocco',
            'star_rating' => 5,
            'price_per_night' => 200.00,
            'image' => 'hotels/royal-mirage.jpg',
            'amenities' => json_encode(['wifi', 'pool', 'spa', 'restaurant']),
            'latitude' => 30.4278,
            'longitude' => -9.5981,
        ]);

        $transport = User::create([
            'name' => 'Transport User',
            'email' => 'transport@transport.com',
            'password' => 'transport123',
            'role' => 'transport',
            'status' => 'valide',
        ]);

        Transport::create([
            'user_id' => $transport->id,
            'company_name' => 'Morocco Express',
            'license_number' => 'T54321',
            'transport_type' => 'Tourist vehicle',
            'address' => '456 Main Street, Casablanca',
            'phone' => '+212 555-1234',
        ]);
    }
}
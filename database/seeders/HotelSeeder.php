<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get hotel users
        $hotelUsers = User::where('role', 'hotel')->get();
        
        if ($hotelUsers->isEmpty()) {
            // If no hotel users, create at least one
            $user = User::create([
                'name' => 'Hotel Manager',
                'email' => 'hotel@example.com', 
                'password' => 'password',
                'role' => 'hotel'
            ]);
            $hotelUsers = collect([$user]);
        }
        
        $hotels = [
            [
                'name' => 'Grand Luxury Hotel',
                'description' => 'A luxurious 5-star hotel with stunning views.',
                'address' => '123 Main Street',
                'city' => 'Paris',
                'country' => 'France',
                'star_rating' => 5,
                'price_per_night' => 350.00,
                'image' => 'grand-luxury.jpg',
                'amenities' => json_encode(['Swimming Pool', 'Spa', 'Gym', 'Restaurant', 'Room Service']),
                'latitude' => 48.8566,
                'longitude' => 2.3522,
            ],
            [
                'name' => 'Coastal Retreat',
                'description' => 'Beachfront hotel with private access to the beach.',
                'address' => '456 Ocean Drive',
                'city' => 'Bali',
                'country' => 'Indonesia',
                'star_rating' => 4,
                'price_per_night' => 220.00,
                'image' => 'coastal-retreat.jpg',
                'amenities' => json_encode(['Beach Access', 'Swimming Pool', 'Restaurant', 'Bar', 'Wifi']),
                'latitude' => -8.4095,
                'longitude' => 115.1889,
            ],
            [
                'name' => 'Urban Oasis Hotel',
                'description' => 'Modern hotel in the heart of the city.',
                'address' => '789 City Center',
                'city' => 'Tokyo',
                'country' => 'Japan',
                'star_rating' => 4,
                'price_per_night' => 280.00,
                'image' => 'urban-oasis.jpg',
                'amenities' => json_encode(['Gym', 'Restaurant', 'Business Center', 'Wifi', 'Concierge']),
                'latitude' => 35.6762,
                'longitude' => 139.6503,
            ],
        ];
        
        foreach ($hotels as $index => $hotel) {
            // Assign hotel to a hotel user (if available), otherwise use the first hotel user
            $userId = isset($hotelUsers[$index]) ? $hotelUsers[$index]->id : $hotelUsers->first()->id;
            
            Hotel::create([
                'user_id' => $userId,
                'name' => $hotel['name'],
                'description' => $hotel['description'],
                'address' => $hotel['address'],
                'city' => $hotel['city'],
                'country' => $hotel['country'],
                'star_rating' => $hotel['star_rating'],
                'price_per_night' => $hotel['price_per_night'],
                'image' => $hotel['image'],
                'amenities' => $hotel['amenities'],
                'latitude' => $hotel['latitude'],
                'longitude' => $hotel['longitude'],
            ]);
        }
    }
}

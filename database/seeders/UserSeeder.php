<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transport;
use App\Models\Traveller;
use App\Models\Itinerary;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Trip;

class UserSeeder extends Seeder
{
    public function run()
    {
        $trip = Trip::create([
            'start_date' => now(),
            'destination' => 'Marrakech',
            'end_date' => now()->addDays(5),
            'cover_picture' => 'marrakech-initial.jpg',
        ]);

        $itinerary = Itinerary::create([
            'description' => 'Explore the city and desert.',
            'title' => 'Marrakech Adventure',
            'trip_id' => $trip->id,
        ]);

        $admin = User::firstOrCreate([
            'name' => 'admin',
            'role' => 'admin',
            'password' => 'admin123',
            'email' => 'admin@admin.com',
            'picture' => 'storage/pictures/admin.jpg',
        ]);

        $traveller = User::firstOrCreate([
            'name' => 'traveller',
            'role' => 'traveller',
            'password' => 'traveller123',
            'email' => 'traveller@traveller.com',
            'picture' => 'storage/pictures/traveller.jpg',
        ]);

        Traveller::create([
            'trip_id' => $trip->id,
            'nationality' => 'Moroccan',
            'user_id' => $traveller->id,
            'passport_number' => 'A1234567',
            'itinerary_id' => $itinerary->id,
            'prefered_destination' => 'Marrakech',
        ]);

        $guide = User::firstOrCreate([
            'name' => 'guide',
            'role' => 'guide',
            'password' => 'guide123',
            'email' => 'guide@guide.com',
            'picture' => 'storage/pictures/guide.jpg',
        ]);

        Guide::create([
            'user_id' => $guide->id,
            'license_number' => 'G1234567',
            'specialization' => 'Cultural Guide',
        ]);

        $company = User::firstOrCreate([
            'name' => 'transport',
            'password' => 'transport123',
            'role' => 'transport company',
            'email' => 'transport@transport.com',
            'picture' => 'storage/pictures/transportcompany.jpg',
        ]);

        if (!Transport::where('user_id', $company->id)->exists()) {
            Transport::create([
                'address' => '123 Travel St., City Center',
                'company_name' => 'Best Travel Co.',
                'license_number' => 'USER-123456',
                'user_id' => $company->id,
                'transport_type' => 'Bus',
                'phone' => '0600000000',
            ]);
        }

        $hotel = User::firstOrCreate([
            'name' => 'hotel',
            'role' => 'hotel',
            'password' => 'hotel123',
            'email' => 'hotel@hotel.com',
            'picture' => 'storage/pictures/hotel.jpg',
        ]);

        Hotel::create([
            'description' => 'A 5-star hotel in the heart of the city.',
            'amenities' => json_encode(['Wi-Fi', 'Pool', 'Gym']),
            'address' => '456 Luxury Rd., City Center',
            'image' => 'hotel_image.jpg',
            'price_per_night' => 200.00,
            'name' => 'Luxury Hotel',
            'user_id' => $hotel->id,
            'country' => 'Morocco',
            'city' => 'Marrakech',
            'longitude' => -8.005,
            'latitude' => 31.645,
            'star_rating' => 5,
        ]);
    }
}
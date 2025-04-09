<?php

namespace Database\Seeders;

use App\Models\TransportCompany;
use Illuminate\Database\Seeder;
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
            'destination' => 'Marrakech',
            'start_date' => now(),
            'end_date' => now()->addDays(5),
        ]);

        $itinerary = Itinerary::create([
            'title' => 'Marrakech Adventure',
            'description' => 'Explore the city and desert.',
            'trip_id' => $trip->id,
        ]);

        $admin = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'admin',
            'password' => 'admin123',  // Plain text password
            'role' => 'admin',
            'picture' => 'storage/pictures/admin.jpg',
        ]);

        $traveller = User::firstOrCreate([
            'email' => 'traveller@traveller.com',
        ], [
            'name' => 'traveller',
            'password' => 'traveller123',  // Plain text password
            'role' => 'traveller',
            'picture' => 'storage/pictures/traveller.jpg',
        ]);

        Traveller::create([
            'user_id' => $traveller->id,
            'trip_id' => $trip->id,
            'itinerary_id' => $itinerary->id,
            'nationality' => 'Moroccan',
            'passport_number' => 'A1234567',
            'prefered_destination' => 'Marrakech',
        ]);

        $guide = User::firstOrCreate([
            'email' => 'guide@guide.com',
        ], [
            'name' => 'guide',
            'password' => 'guide123',  // Plain text password
            'role' => 'guide',
            'picture' => 'storage/pictures/guide.jpg',
        ]);

        Guide::create([
            'user_id' => $guide->id,
            'license_number' => 'G1234567',
            'specialization' => 'Cultural Guide',
        ]);

        $company = User::firstOrCreate([
            'email' => 'company@company.com',
        ], [
            'name' => 'travel company',
            'password' => 'company123',  // Plain text password
            'role' => 'transport company',
            'picture' => 'storage/pictures/transportcompany.jpg',
        ]);

        TransportCompany::create([
            'user_id' => $company->id,
            'company_name' => 'Best Travel Co.',
            'transport_type' => 'Bus',
            'license_number' => 'T123456',
            'address' => '123 Travel St., City Center',
            'phone' => '0600000000',
        ]);

        $hotel = User::firstOrCreate([
            'email' => 'hotel@hotel.com',
        ], [
            'name' => 'hotel',
            'password' => 'hotel123',  // Plain text password
            'role' => 'hotel',
            'picture' => 'storage/pictures/hotel.jpg',
        ]);

        Hotel::create([
            'user_id' => $hotel->id,
            'name' => 'Luxury Hotel',
            'description' => 'A 5-star hotel in the heart of the city.',
            'address' => '456 Luxury Rd., City Center',
            'city' => 'Marrakech',
            'country' => 'Morocco',
            'star_rating' => 5,
            'price_per_night' => 200.00,
            'image' => 'hotel_image.jpg',
            'amenities' => json_encode(['Wi-Fi', 'Pool', 'Gym']),
            'latitude' => 31.645,
            'longitude' => -8.005,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(){
        $trips = [
            [
                'end_date' => '2024-06-22',
                'start_date' => '2024-06-15',
                'destination' => 'Paris, France',
                'cover_picture' => 'paris-trip.jpg',
            ],
            [
                'end_date' => '2024-07-20',
                'start_date' => '2024-07-10',
                'destination' => 'Marrakech, Morocco',
                'cover_picture' => 'marrakech-trip.jpg',
            ],
            [
                'destination' => 'Bali, Indonesia',
                'cover_picture' => 'bali-trip.jpg',
                'start_date' => '2024-08-05',
                'end_date' => '2024-08-15',
            ],
            [
                'cover_picture' => 'tokyo-trip.jpg',
                'destination' => 'Tokyo, Japan',
                'start_date' => '2024-09-12',
                'end_date' => '2024-09-22',
            ],
            [
                'cover_picture' => 'newyork-trip.jpg',
                'destination' => 'New York, USA',
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-08',
            ],
        ];
        
        foreach ($trips as $trip) {
            Trip::create([
                'cover_picture' => $trip['cover_picture'],
                'destination' => $trip['destination'],
                'start_date' => $trip['start_date'],
                'end_date' => $trip['end_date'],
            ]);
        }
    }
}
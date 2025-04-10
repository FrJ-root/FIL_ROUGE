<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trips = [
            [
                'destination' => 'Paris, France',
                'start_date' => '2024-06-15',
                'end_date' => '2024-06-22',
                'cover_picture' => 'paris-trip.jpg',
            ],
            [
                'destination' => 'Marrakech, Morocco',
                'start_date' => '2024-07-10',
                'end_date' => '2024-07-20',
                'cover_picture' => 'marrakech-trip.jpg',
            ],
            [
                'destination' => 'Bali, Indonesia',
                'start_date' => '2024-08-05',
                'end_date' => '2024-08-15',
                'cover_picture' => 'bali-trip.jpg',
            ],
            [
                'destination' => 'Tokyo, Japan',
                'start_date' => '2024-09-12',
                'end_date' => '2024-09-22',
                'cover_picture' => 'tokyo-trip.jpg',
            ],
            [
                'destination' => 'New York, USA',
                'start_date' => '2024-10-01',
                'end_date' => '2024-10-08',
                'cover_picture' => 'newyork-trip.jpg',
            ],
        ];
        
        foreach ($trips as $trip) {
            Trip::create([
                'destination' => $trip['destination'],
                'start_date' => $trip['start_date'],
                'end_date' => $trip['end_date'],
                'cover_picture' => $trip['cover_picture'],
            ]);
        }
    }
}

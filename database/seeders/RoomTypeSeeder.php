<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        $roomTypes = [
            [
                'name' => 'Standard',
                'description' => 'A comfortable room with all basic amenities',
            ],
            [
                'name' => 'Deluxe',
                'description' => 'A spacious room with premium amenities and services',
            ],
            [
                'name' => 'Suite',
                'description' => 'A luxury accommodation with separate living area and bedroom',
            ],
            [
                'name' => 'Family',
                'description' => 'A large room suitable for families with children',
            ],
            [
                'name' => 'Single',
                'description' => 'A cozy room designed for one person',
            ],
            [
                'name' => 'Twin',
                'description' => 'A room with two single beds',
            ],
        ];

        foreach ($roomTypes as $type) {
            RoomType::create($type);
        }
    }
}
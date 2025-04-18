<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    public function run(){
        $destinations = [
            [
                'name' => 'Paris',
                'location' => 'France',
                'description' => 'The City of Light famous for its art, culture, and cuisine.',
                'is_featured' => true,
                'image' => 'paris.jpg',
            ],
            [
                'name' => 'Marrakech',
                'location' => 'Morocco',
                'description' => 'A vibrant city with bustling markets and rich cultural heritage.',
                'is_featured' => true,
                'image' => 'marrakech.jpg',
            ],
            [
                'name' => 'Bali',
                'location' => 'Indonesia',
                'description' => 'Tropical paradise with beautiful beaches and spiritual retreats.',
                'is_featured' => true,
                'image' => 'bali.jpg',
            ],
            [
                'name' => 'Tokyo',
                'location' => 'Japan',
                'description' => 'Ultra-modern city with a blend of traditional culture.',
                'is_featured' => false,
                'image' => 'tokyo.jpg',
            ],
            [
                'name' => 'New York',
                'location' => 'USA',
                'description' => 'The city that never sleeps with iconic landmarks and diverse culture.',
                'is_featured' => false,
                'image' => 'newyork.jpg',
            ],
            [
                'name' => 'Cape Town',
                'location' => 'South Africa',
                'description' => 'Stunning coastal city with beautiful mountains and beaches.',
                'is_featured' => false,
                'image' => 'capetown.jpg',
            ],
            [
                'name' => 'Rio de Janeiro',
                'location' => 'Brazil',
                'description' => 'Vibrant city known for its beaches, mountains, and carnival.',
                'is_featured' => false,
                'image' => 'rio.jpg',
            ],
            [
                'name' => 'Sydney',
                'location' => 'Australia',
                'description' => 'Iconic harbor city with beautiful beaches and landmarks.',
                'is_featured' => false,
                'image' => 'sydney.jpg',
            ],
        ];
        
        foreach ($destinations as $destination) {
            Destination::firstOrCreate(
                ['slug' => Str::slug($destination['name'])],
                [
                    'name' => $destination['name'],
                    'description' => $destination['description'],
                    'image' => $destination['image'],
                    'location' => $destination['location'],
                    'is_featured' => $destination['is_featured'],
                    'meta_title' => 'Visit '.$destination['name'],
                    'meta_description' => 'Plan your trip to '.$destination['name'].', '.$destination['location'],
                ]
            );
        }
    }
}
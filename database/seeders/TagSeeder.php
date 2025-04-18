<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Family Friendly',
            'Food & Cuisine',
            'Solo Traveler',
            'Art & Museums',
            'Eco-Friendly',
            'Photography',
            'Snorkeling',
            'Relaxation',
            'Road Trip',
            'Nightlife',
            'Wellness',
            'Shopping',
            'Swimming',
            'Couples',
            'Surfing',
            'History',
            'Luxury',
            'Budget',
            'Hiking',
            'Skiing',
        ];
        
        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                [
                    'name' => $tagName,
                    'meta_title' => $tagName . ' Trips',
                    'description' => 'Trips related to ' . strtolower($tagName),
                    'meta_description' => 'Find the best trips for ' . strtolower($tagName),
                ]
            );
        }
    }
}
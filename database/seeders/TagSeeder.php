<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Family Friendly',
            'Solo Traveler',
            'Couples',
            'Luxury',
            'Budget',
            'Eco-Friendly',
            'Photography',
            'Food & Cuisine',
            'History',
            'Art & Museums',
            'Hiking',
            'Swimming',
            'Snorkeling',
            'Surfing',
            'Skiing',
            'Relaxation',
            'Wellness',
            'Nightlife',
            'Shopping',
            'Road Trip',
        ];
        
        foreach ($tags as $tagName) {
            // Use firstOrCreate to prevent duplicate entries
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                [
                    'name' => $tagName,
                    'description' => 'Trips related to ' . strtolower($tagName),
                    'meta_title' => $tagName . ' Trips',
                    'meta_description' => 'Find the best trips for ' . strtolower($tagName),
                ]
            );
        }
    }
}

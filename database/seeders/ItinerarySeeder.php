<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Itinerary;
use App\Models\Trip;

class ItinerarySeeder extends Seeder
{
    public function run(){
        $trips = Trip::whereNotIn('id', function($query) {
            $query->select('trip_id')->from('itineraries');
        })->get();
        
        if ($trips->isEmpty()) {
            return;
        }
        
        $itineraryTemplates = [
            [
                'title' => 'Romantic Parisian Adventure',
                'description' => 'Explore the most romantic spots in Paris, including the Eiffel Tower, Seine River cruise, and Montmartre.',
            ],
            [
                'title' => 'Moroccan Cultural Immersion',
                'description' => 'Dive into Moroccan culture with visits to the markets, palaces, and desert excursions.',
            ],
            [
                'title' => 'Bali Paradise Retreat',
                'description' => 'Relax and rejuvenate on the beautiful beaches of Bali, with visits to temples and rice terraces.',
            ],
            [
                'title' => 'Tokyo Urban Explorer',
                'description' => 'Experience the perfect blend of traditional and modern Japan in Tokyo.',
            ],
            [
                'title' => 'New York City Discovery',
                'description' => 'Experience the best of NYC with visits to iconic landmarks, museums, and neighborhoods.',
            ],
        ];
        
        foreach ($trips as $index => $trip) {
            $itineraryData = $itineraryTemplates[$index % count($itineraryTemplates)];
            
            Itinerary::create([
                'trip_id' => $trip->id,
                'title' => $itineraryData['title'],
                'description' => $itineraryData['description'],
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $trips = Trip::all();
        
        if ($trips->isEmpty()) {
            return;
        }
        
        $activityTemplates = [
            [
                [
                    'name' => 'Eiffel Tower Visit',
                    'location' => 'Eiffel Tower, Paris',
                    'description' => 'Visit the iconic Eiffel Tower and enjoy panoramic views of Paris.',
                    'day_offset' => 1,
                ],
                [
                    'name' => 'Louvre Museum Tour',
                    'location' => 'Louvre Museum, Paris',
                    'description' => 'Guided tour of the world-famous Louvre Museum, home to the Mona Lisa.',
                    'day_offset' => 2,
                ],
                [
                    'name' => 'Seine River Cruise',
                    'location' => 'Seine River, Paris',
                    'description' => 'Romantic evening cruise along the Seine River with dinner.',
                    'day_offset' => 3,
                ],
            ],
            [
                [
                    'name' => 'Medina Exploration',
                    'location' => 'Medina, Marrakech',
                    'description' => 'Guided walk through the ancient Medina and its bustling souks.',
                    'day_offset' => 1,
                ],
                [
                    'name' => 'Majorelle Garden Visit',
                    'location' => 'Majorelle Garden, Marrakech',
                    'description' => 'Visit the stunning blue Majorelle Garden and YSL Museum.',
                    'day_offset' => 2,
                ],
                [
                    'name' => 'Desert Camel Ride',
                    'location' => 'Agafay Desert, Marrakech',
                    'description' => 'Sunset camel ride in the desert followed by traditional dinner.',
                    'day_offset' => 3,
                ],
            ],
            [
                [
                    'name' => 'Ubud Sacred Monkey Forest',
                    'location' => 'Ubud, Bali',
                    'description' => 'Visit the sacred monkey forest sanctuary with hundreds of monkeys.',
                    'day_offset' => 1,
                ],
                [
                    'name' => 'Rice Terrace Trek',
                    'location' => 'Tegallalang, Bali',
                    'description' => 'Trek through the beautiful rice terraces of Tegallalang.',
                    'day_offset' => 2,
                ],
                [
                    'name' => 'Tanah Lot Temple Sunset',
                    'location' => 'Tanah Lot, Bali',
                    'description' => 'Watch the sunset at the beautiful sea temple of Tanah Lot.',
                    'day_offset' => 3,
                ],
            ],
        ];
        
        foreach ($trips as $index => $trip) {
            $templateIndex = $index % count($activityTemplates);
            $activities = $activityTemplates[$templateIndex];
            
            $startDate = new \DateTime($trip->start_date);
            
            foreach ($activities as $activity) {
                $activityDate = clone $startDate;
                $activityDate->modify('+' . $activity['day_offset'] . ' days');
                
                Activity::create([
                    'trip_id' => $trip->id,
                    'name' => $activity['name'],
                    'location' => $activity['location'],
                    'description' => $activity['description'],
                    'scheduled_at' => $activityDate->format('Y-m-d 10:00:00'),
                ]);
            }
        }
    }
}

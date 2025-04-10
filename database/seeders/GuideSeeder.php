<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get guide users
        $guideUsers = User::where('role', 'guide')->get();
        
        if ($guideUsers->isEmpty()) {
            // If no guide users, create at least one
            $user = User::create([
                'name' => 'Tour Guide',
                'email' => 'guide@example.com', 
                'password' => 'password',
                'role' => 'guide'
            ]);
            $guideUsers = collect([$user]);
        }
        
        $guides = [
            [
                'license_number' => 'G-12345',
                'specialization' => 'Cultural Tours',
            ],
            [
                'license_number' => 'G-23456',
                'specialization' => 'Adventure Tours',
            ],
            [
                'license_number' => 'G-34567',
                'specialization' => 'Historical Tours',
            ],
        ];
        
        foreach ($guides as $index => $guide) {
            // Assign guide to a guide user (if available), otherwise use the first guide user
            $userId = isset($guideUsers[$index]) ? $guideUsers[$index]->id : $guideUsers->first()->id;
            
            Guide::create([
                'user_id' => $userId,
                'license_number' => $guide['license_number'],
                'specialization' => $guide['specialization'],
            ]);
        }
    }
}

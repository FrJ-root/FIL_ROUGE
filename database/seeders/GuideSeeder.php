<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;
use App\Models\User;

class GuideSeeder extends Seeder
{
    public function run(){
        $guideUsers = User::where('role', 'guide')->get();
        
        if ($guideUsers->isEmpty()) {
            $user = User::create([
                'name' => 'Tour Guide',
                'email' => 'guide@guide.com', 
                'password' => 'guide123',
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
            $userId = isset($guideUsers[$index]) ? $guideUsers[$index]->id : $guideUsers->first()->id;
            Guide::create([
                'user_id' => $userId,
                'license_number' => $guide['license_number'],
                'specialization' => $guide['specialization'],
            ]);
        }
    }
}
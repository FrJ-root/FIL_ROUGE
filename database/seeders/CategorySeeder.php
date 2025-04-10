<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Adventure',
                'description' => 'Exciting adventures for thrill-seekers',
                'is_featured' => true,
                'image' => 'adventure.jpg',
            ],
            [
                'name' => 'Cultural',
                'description' => 'Explore local customs and traditions',
                'is_featured' => true,
                'image' => 'cultural.jpg',
            ],
            [
                'name' => 'Beach',
                'description' => 'Relax on beautiful beaches',
                'is_featured' => true,
                'image' => 'beach.jpg',
            ],
            [
                'name' => 'Mountain',
                'description' => 'Explore majestic mountains and peaks',
                'is_featured' => false,
                'image' => 'mountain.jpg',
            ],
            [
                'name' => 'City Break',
                'description' => 'Short trips to explore vibrant cities',
                'is_featured' => false,
                'image' => 'city.jpg',
            ],
            [
                'name' => 'Wildlife',
                'description' => 'Experience nature and wildlife up close',
                'is_featured' => false,
                'image' => 'wildlife.jpg',
            ],
        ];
        
        foreach ($categories as $category) {
            // Use firstOrCreate to prevent duplicate entries
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'is_featured' => $category['is_featured'],
                    'meta_title' => $category['name'] . ' Trips',
                    'meta_description' => 'Find the best ' . strtolower($category['name']) . ' trips.',
                ]
            );
        }
    }
}

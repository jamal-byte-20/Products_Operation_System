<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Gadgets and tech', 'icon' => '📱'],
            ['name' => 'Clothing', 'slug' => 'clothing', 'description' => 'Fashion and apparel', 'icon' => '👕'],
            ['name' => 'Books', 'slug' => 'books', 'description' => 'Reading materials', 'icon' => '📚'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Home decor', 'icon' => '🏠'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports equipment', 'icon' => '⚽'],
            ['name' => 'Beauty', 'slug' => 'beauty', 'description' => 'Beauty products', 'icon' => '💄'],
            ['name' => 'Toys', 'slug' => 'toys', 'description' => 'Games', 'icon' => '🎮'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
        
        $this->command->info('Categories seeded successfully!');
    }
}
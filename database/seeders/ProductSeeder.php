<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                'name' => "Product {$i}",
                'description' => "This is the description for product {$i}.",
                'price' => rand(50, 500),
                'stock' => rand(1, 100),
                'quantity' => rand(1,100),
                'image' => i
            ]);
        }
    }
}

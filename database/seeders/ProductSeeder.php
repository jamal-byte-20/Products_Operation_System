<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get all categories for reference
        $categories = Category::all();
        
        // Define products with their categories (many-to-many via pivot)
        $productsData = [
            // Electronics products
            [
                'name' => 'MacBook Pro 14" M3',
                'description' => 'Apple MacBook Pro with M3 chip, 16GB RAM, 512GB SSD, Liquid Retina XDR display.',
                'price' => 1999.99,
                'stock' => 15,
                'quantity' => 15,
                'image' => 'https://picsum.photos/id/0/400/300',
                'categories' => ['Electronics']
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise cancellation, 30-hour battery life, exceptional sound quality.',
                'price' => 399.99,
                'stock' => 42,
                'quantity' => 42,
                'image' => 'https://picsum.photos/id/1/400/300',
                'categories' => ['Electronics', 'Sports'] // Product belongs to 2 categories
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'A17 Pro chip, titanium design, 48MP main camera with 5x optical zoom.',
                'price' => 1199.99,
                'stock' => 25,
                'quantity' => 25,
                'image' => 'https://picsum.photos/id/2/400/300',
                'categories' => ['Electronics', 'Photography']
            ],
            
            // Clothing products
            [
                'name' => 'Nike Air Max 90',
                'description' => 'Classic sneakers with iconic Air cushioning, leather and mesh upper.',
                'price' => 129.99,
                'stock' => 35,
                'quantity' => 35,
                'image' => 'https://picsum.photos/id/4/400/300',
                'categories' => ['Clothing', 'Sports']
            ],
            [
                'name' => "Levi's 501 Original Jeans",
                'description' => 'The original blue jeans, straight fit, button fly, 100% cotton denim.',
                'price' => 89.99,
                'stock' => 50,
                'quantity' => 50,
                'image' => 'https://picsum.photos/id/5/400/300',
                'categories' => ['Clothing']
            ],
            [
                'name' => 'The North Face Jacket',
                'description' => 'Waterproof breathable jacket with DryVent technology, adjustable hood.',
                'price' => 249.99,
                'stock' => 12,
                'quantity' => 12,
                'image' => 'https://picsum.photos/id/6/400/300',
                'categories' => ['Clothing', 'Sports']
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'Running shoes with responsive Boost midsole, Primeknit upper.',
                'price' => 179.99,
                'stock' => 23,
                'quantity' => 23,
                'image' => 'https://picsum.photos/id/7/400/300',
                'categories' => ['Clothing', 'Sports']
            ],
            
            // Books products
            [
                'name' => 'Clean Code by Robert Martin',
                'description' => 'Handbook of agile software craftsmanship, best practices for writing maintainable code.',
                'price' => 45.99,
                'stock' => 60,
                'quantity' => 60,
                'image' => 'https://picsum.photos/id/8/400/300',
                'categories' => ['Books', 'Technology']
            ],
            [
                'name' => 'The Pragmatic Programmer',
                'description' => 'Your journey to mastery, practical advice on software development.',
                'price' => 39.99,
                'stock' => 45,
                'quantity' => 45,
                'image' => 'https://picsum.photos/id/9/400/300',
                'categories' => ['Books', 'Technology']
            ],
            [
                'name' => 'Laravel: Up & Running',
                'description' => 'Complete guide to Laravel development, from basics to advanced features.',
                'price' => 49.99,
                'stock' => 30,
                'quantity' => 30,
                'image' => 'https://picsum.photos/id/10/400/300',
                'categories' => ['Books', 'Technology']
            ],
            
            // Home & Garden products
            [
                'name' => 'Dyson V15 Vacuum Cleaner',
                'description' => 'Cordless vacuum with laser detection, 230AW suction power.',
                'price' => 699.99,
                'stock' => 7,
                'quantity' => 7,
                'image' => 'https://picsum.photos/id/11/400/300',
                'categories' => ['Home & Garden', 'Electronics']
            ],
            [
                'name' => 'Instant Pot Duo 7-in-1',
                'description' => 'Pressure cooker, slow cooker, rice cooker, steamer, and more.',
                'price' => 99.99,
                'stock' => 25,
                'quantity' => 25,
                'image' => 'https://picsum.photos/id/12/400/300',
                'categories' => ['Home & Garden']
            ],
            [
                'name' => 'Casper Sleep Pillow',
                'description' => 'Adjustable foam pillow, breathable cover, support for all sleep positions.',
                'price' => 74.99,
                'stock' => 18,
                'quantity' => 18,
                'image' => 'https://picsum.photos/id/13/400/300',
                'categories' => ['Home & Garden', 'Health']
            ],
            
            // Sports products
            [
                'name' => 'YETI Rambler Tumbler',
                'description' => 'Stainless steel vacuum insulated tumbler, keeps drinks hot or cold.',
                'price' => 39.99,
                'stock' => 55,
                'quantity' => 55,
                'image' => 'https://picsum.photos/id/14/400/300',
                'categories' => ['Sports']
            ],
            [
                'name' => 'Peloton Bike',
                'description' => 'Indoor exercise bike with 22" HD touchscreen, live and on-demand classes.',
                'price' => 1445.00,
                'stock' => 3,
                'quantity' => 3,
                'image' => 'https://picsum.photos/id/15/400/300',
                'categories' => ['Sports', 'Electronics']
            ],
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Eco-friendly non-slip yoga mat, 6mm thickness, perfect for all exercises.',
                'price' => 49.99,
                'stock' => 40,
                'quantity' => 40,
                'image' => 'https://picsum.photos/id/16/400/300',
                'categories' => ['Sports', 'Health']
            ],
            
            // Beauty products
            [
                'name' => 'Dyson Airwrap Styler',
                'description' => 'Multi-styler and dryer for curls, waves, smooth and volume.',
                'price' => 599.99,
                'stock' => 10,
                'quantity' => 10,
                'image' => 'https://picsum.photos/id/17/400/300',
                'categories' => ['Beauty', 'Electronics']
            ],
            [
                'name' => 'Premium Skincare Set',
                'description' => 'Complete skincare routine with cleanser, serum, moisturizer, and SPF.',
                'price' => 89.99,
                'stock' => 28,
                'quantity' => 28,
                'image' => 'https://picsum.photos/id/18/400/300',
                'categories' => ['Beauty', 'Health']
            ],
            
            // Toys products
            [
                'name' => 'LEGO Star Wars Millennium Falcon',
                'description' => 'Build iconic Star Wars ship with 1,351 pieces, includes 7 minifigures.',
                'price' => 159.99,
                'stock' => 14,
                'quantity' => 14,
                'image' => 'https://picsum.photos/id/19/400/300',
                'categories' => ['Toys']
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => '7-inch OLED screen, 64GB storage, enhanced audio, LAN port.',
                'price' => 349.99,
                'stock' => 20,
                'quantity' => 20,
                'image' => 'https://picsum.photos/id/20/400/300',
                'categories' => ['Toys', 'Electronics']
            ],
            
            // More cross-category products
            [
                'name' => 'Wireless Gaming Mouse',
                'description' => 'RGB gaming mouse with 16000 DPI, 7 programmable buttons.',
                'price' => 59.99,
                'stock' => 32,
                'quantity' => 32,
                'image' => 'https://picsum.photos/id/21/400/300',
                'categories' => ['Electronics', 'Toys']
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracker with heart rate monitor, GPS, 7-day battery life.',
                'price' => 199.99,
                'stock' => 18,
                'quantity' => 18,
                'image' => 'https://picsum.photos/id/22/400/300',
                'categories' => ['Electronics', 'Sports', 'Health']
            ],
            [
                'name' => 'Coffee Maker Deluxe',
                'description' => 'Programmable coffee maker with thermal carafe, built-in grinder.',
                'price' => 129.99,
                'stock' => 22,
                'quantity' => 22,
                'image' => 'https://picsum.photos/id/23/400/300',
                'categories' => ['Home & Garden', 'Food & Beverage']
            ],
        ];

        // Create products and attach categories to pivot table
        foreach ($productsData as $productData) {
            // Extract categories names from product data
            $categoryNames = $productData['categories'];
            unset($productData['categories']); // Remove categories from product data
            
            // Create the product (NO category_id field!)
            $product = Product::create($productData);
            
            // Find category IDs by name
            $categoryIds = [];
            foreach ($categoryNames as $catName) {
                $category = $categories->firstWhere('name', $catName);
                if ($category) {
                    $categoryIds[] = $category->id;
                } else {
                    // Create category if it doesn't exist
                    $newCategory = Category::create([
                        'name' => $catName,
                        'slug' => Str::slug($catName),
                        'description' => 'Auto-generated category',
                        'icon' => '🏷️'
                    ]);
                    $categoryIds[] = $newCategory->id;
                    $this->command->warn("Created new category: {$catName}");
                }
            }
            
            // ATTACH to pivot table (product_category)
            $product->categories()->attach($categoryIds);
            
            $this->command->info("✓ Product '{$product->name}' created with " . count($categoryIds) . " categories");
        }
        
        // Display statistics
        $this->command->newLine();
        $this->command->info("✅ Products seeded successfully!");
        $this->command->info("📦 Total products: " . Product::count());
        $this->command->info("🏷️ Total categories: " . Category::count());
        $this->command->info("🔗 Total relationships in product_category: " . \DB::table('product_category')->count());
    }
}
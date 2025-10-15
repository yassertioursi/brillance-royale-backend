<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        foreach ($categories as $category) {
            for ($i = 1; $i <= 5; $i++) {
                $name = "{$category->name} modèle $i";


                $base = rand(2000, 8000) / 100;
                $sizes = [
                    ['size' => 'S', 'price' => $base],
                    ['size' => 'M', 'price' => round($base * 1.15, 2)],
                    ['size' => 'L', 'price' => round($base * 1.30, 2)],
                ];


                $explicitBasePrice = rand(0,1) ? $base : null;

                Product::create([
                    'category_id'      => $category->id,
                    'name'             => $name,
                    'price'            => $explicitBasePrice,
                    'promo_price'      => rand(0, 1) ? rand(1000, 12000) / 100 : null,
                    'is_promo'         => rand(0, 1),
                    'promo_start_date' => now()->subDays(rand(0, 10)),
                    'promo_end_date'   => now()->addDays(rand(1, 10)),
                    'stock_quantity'   => rand(5, 50),
                    'description'      => "Magnifique {$category->name} fabriqué à la main, parfait pour toutes les occasions.",
                    'brand'            => fake()->company(),
                    'reference'        => strtoupper(Str::random(8)),
                    'images'           => [
                        "products/sample_{$i}_1.jpg",
                        "products/sample_{$i}_2.jpg",
                    ],
                    'size_prices'      => $sizes,
                ]);
            }
        }
    }
}

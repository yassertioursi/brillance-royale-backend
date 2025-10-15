<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Électronique',
            'Mode',
            'Beauté & Santé',
            'Maison & Décoration',
            'Sports & Loisirs',
            'Jouets & Enfants',
            'Alimentation',
            'Informatique',
            'Téléphones & Accessoires',
            'Automobile',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}

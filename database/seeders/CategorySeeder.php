<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Packaging (4)
        Category::create([
            'product_id' => 1,
            'name' => 'Primary',
            'slug' => 'primary'
        ]);
        Category::create([
            'product_id' => 1,
            'name' => 'Secondary',
            'slug' => 'secondary'
        ]);
        Category::create([
            'product_id' => 1,
            'name' => 'Tertiary',
            'slug' => 'tertiary'
        ]);
        Category::create([
            'product_id' => 1,
            'name' => 'Eco-Friendly',
            'slug' => 'eco-friendly'
        ]);

        // Banners (5)
        Category::create([
            'product_id' => 2,
            'name' => 'X-Banner',
            'slug' => 'x-Banner'
        ]);
        Category::create([
            'product_id' => 2,
            'name' => 'Y-Banner',
            'slug' => 'y-Banner'
        ]);
        Category::create([
            'product_id' => 2,
            'name' => 'Roll Up Banner',
            'slug' => 'roll-up-banner'
        ]);
        Category::create([
            'product_id' => 2,
            'name' => 'Flag Banner',
            'slug' => 'flag-banner'
        ]);
        Category::create([
            'product_id' => 2,
            'name' => 'Giant Banner',
            'slug' => 'giant-banner'
        ]);

        // Stickers (9)
        Category::create([
            'product_id' => 3,
            'name' => 'Vinyl',
            'slug' => 'vinyl'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'HVS',
            'slug' => 'hvs'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'Chromo',
            'slug' => 'chromo'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'Foil',
            'slug' => 'foil'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'Bontax',
            'slug' => 'bontax'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'Yupo',
            'slug' => 'yupo'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'Scotchlite',
            'slug' => 'scotchlite'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'One Way',
            'slug' => 'one-way'
        ]);
        Category::create([
            'product_id' => 3,
            'name' => 'Transparan',
            'slug' => 'transparan'
        ]);
    }
}

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
        Product::create([
            'name' => 'Packaging',
            'slug' => 'packaging'
        ]);
        Product::create([
            'name' => 'Banners',
            'slug' => 'banners'
        ]);
        Product::create([
            'name' => 'Stickers',
            'slug' => 'stickers'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = Option::create([
            'name' => 'Usage Type',
            'slug' => 'usage-type'
        ]);
        // Relasikan opsi ke produk
        $productType = Product::whereIn('id', [1])->get();
        foreach ($productType as $product) {
            $product->options()->attach($type->id);
        }

        $size = Option::create([
            'name' => 'Size',
            'slug' => 'size'
        ]);
        // Relasikan opsi ke produk
        $productSize = Product::whereIn('id', [2, 3])->get();
        foreach ($productSize as $product) {
            $product->options()->attach($size->id);
        }
        
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promotion_products')->insert([
            ['promotion_id' => 1, 'product_id' => 1], // Packaging
            ['promotion_id' => 1, 'product_id' => 3], // Stickers
        ]);
    }
}

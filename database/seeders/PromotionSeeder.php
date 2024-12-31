<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promotions')->insert([
            [
                'title' => 'Bundle: Packaging + Stickers',
                'slug' => 'bundle-packaging-+-stickers',
                'description' => '*Only for VIP Member',
                'price' => 15000,
                'original_price' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

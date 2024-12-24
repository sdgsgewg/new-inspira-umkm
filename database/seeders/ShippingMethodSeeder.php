<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shipping_methods')->insert([
            [
                'name' => 'Standard Delivery',
                'description' => 'Estimated delivery within 3-7 business days.',
                'shipping_fee' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Express Delivery',
                'description' => 'Fast delivery within 1-2 business days.',
                'shipping_fee' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Self Pickup',
                'description' => 'Pick up your order directly from our store.',
                'shipping_fee' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Same-Day Delivery',
                'description' => 'Get your order delivered on the same day.',
                'shipping_fee' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Overnight Delivery',
                'description' => 'Overnight shipping for urgent deliveries.',
                'shipping_fee' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

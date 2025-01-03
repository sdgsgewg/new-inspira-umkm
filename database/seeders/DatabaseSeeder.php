<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                UserSeeder::class,
                ProductSeeder::class,
                CategorySeeder::class,
                DesignSeeder::class,
                OptionSeeder::class,
                OptionValueSeeder::class,
                PaymentMethodSeeder::class,
                ShippingMethodSeeder::class,
                PlanSeeder::class,
                PromotionSeeder::class,
                PromotionPlanSeeder::class,
                PromotionProductSeeder::class
            ]
        );
    }
}

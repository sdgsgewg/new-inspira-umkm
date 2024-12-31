<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Free Plan',
            'slug' => 'free-plan',
            'description' => 'This is the free plan which allow you to only enjoy normal usage of our website.',
            'price' => 0,
            'billing_cycle' => 'daily', // Anggap saja tidak ada
            'features' => json_encode([
                'Limited discounted rates',
                'Limited offer packages'
            ])
        ]);

        Plan::create([
            'name' => 'VIP Plan',
            'slug' => 'vip-plan',
            'description' => 'This plan allows you to enjoy exclusive offers and premium benefits.',
            'price' => 35000,
            'billing_cycle' => 'monthly',
            'features' => json_encode([
                'Special discounted rates',
                'Exclusive offer packages'
            ])
        ]);
    }
}

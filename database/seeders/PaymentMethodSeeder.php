<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'name' => 'GoPay',
            'description' => 'A popular e-wallet service from Gojek, widely used in Indonesia.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PaymentMethod::create([
            'name' => 'OVO',
            'description' => 'A well-known e-wallet in Indonesia, commonly used for online payments.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PaymentMethod::create([
            'name' => 'ShopeePay',
            'description' => 'The e-wallet service by Shopee, used for fast payments on their platform.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PaymentMethod::create([
            'name' => 'Dana',
            'description' => 'An Indonesian e-wallet that offers a variety of payment services and features.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PaymentMethod::create([
            'name' => 'Bank Transfer',
            'description' => 'Direct transfer from your bank account to the seller’s account.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        PaymentMethod::create([
            'name' => 'Credit/Debit Card',
            'description' => 'Secure online payments via your credit or debit card.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

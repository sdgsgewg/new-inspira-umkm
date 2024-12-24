<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jessen',
            'username' => 'jessen',
            'email' => 'jessen123ptk@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'dob' => '2003-11-26',
            'gender' => 'Male',
            'address' => 'Orange Street',
            'phoneNumber' => '08123456789',
            'is_admin' => 1,
            'remember_token' => Str::random(10)
        ]);

        User::factory(3)->create();
    }
}

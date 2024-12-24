<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product as ProductModel;
use App\Models\Category as CategoryModel;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Design>
 */
class DesignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');

        // Randomly select a product
        $productId = ProductModel::inRandomOrder()->first()->id;

        // Randomly select a category that belongs to the chosen product
        $categoryId = CategoryModel::where('product_id', $productId)->inRandomOrder()->first()->id;

        return [
            'seller_id' => 1,
            'product_id' => $productId,
            'category_id' => $categoryId,
            'title' => $faker->sentence(mt_rand(2,8)),
            'slug' => $faker->slug(),
            'description' => collect(range(1, 2))
            ->map(fn() => "<p>" . $faker->text(700) . "</p>")
            ->implode(''),
            'price' => mt_rand(30000, 200000),
            'stock' => mt_rand(1, 20),
        ];
    }
}

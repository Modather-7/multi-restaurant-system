<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);
        $restaurantId = Restaurant::inRandomOrder()->value('id');
        return [
            'name' => $name, // ($nb = 3, $asText = false)
            'category_id' => Category::where('restaurant_id', $restaurantId)->inRandomOrder()->value('id'),
            'restaurant_id' => $restaurantId,
            'ingredients' => fake()->sentence(15), // 15 word sentence
            'price' => fake()->numberBetween(100, 500),
            'compare_price' => fake()->numberBetween(50, 99),
            'featured' => rand(0, 1), // minimum 0 , maximum 1
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 999999),
        ];
    }
}

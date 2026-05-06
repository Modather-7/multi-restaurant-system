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
        return [
            'name' => $name, // ($nb = 3, $asText = false)
            'category_id' => Category::inRandomOrder()->first()->id,
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id,
            'ingredients' => fake()->sentence(15), // 15 word sentence
            'image' => fake()->imageUrl(800, 600),
            'price' => fake()->randomFloat(1, 10, 499),
            'compare_price' => fake()->randomFloat(1, 500, 999),
            'quantity' => fake()->randomNumber(),
            'feautured' => rand(0, 1), // minimum 0 , maximum 1
            'slug' => Str::slug($name),
        ];
    }
}

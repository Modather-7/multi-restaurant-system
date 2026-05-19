<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
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
            'name' => fake()->words(2, true), // ($nb = 3, $asText = false)
            'slug' => Str::slug($name),
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Restaurant>
 */
class RestaurantFactory extends Factory
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
            'description' => fake()->sentence(15), // 15 word sentence
            'logo_image' => fake()->imageUrl(600, 600),
            'cover_image' => fake()->imageUrl(800, 600),
            'slug' => Str::slug($name),
        ];
    }
}

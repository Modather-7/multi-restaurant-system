<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id,
            'password' => Hash::make('12345678'),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}

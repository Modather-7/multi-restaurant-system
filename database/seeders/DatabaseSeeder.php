<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Restaurant::factory(5)->create();

        // \App\Models\Admin::factory(3)->create();

        // Category::factory(10)->create();
        Product::factory(50)->create();

        // $this->call(PermissionSeeder::class);

        // $this->call(UserSeeder::class);
    }
}

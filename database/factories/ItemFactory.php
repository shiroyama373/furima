<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->word(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(1000, 100000),
            'condition' => '良好',
            'image_path' => 'items/sample.jpg',
            'sold' => false,
        ];
    }
}
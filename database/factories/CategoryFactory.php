<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        return [
            'name' => $name,
            'image_url' => fake()->imageUrl(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}

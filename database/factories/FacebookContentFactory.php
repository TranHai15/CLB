<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacebookContentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'prompt' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'image_url' => fake()->imageUrl(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}

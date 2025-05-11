<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacebookContentFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB

        return [
            'prompt' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'image_url' => fake()->imageUrl(),
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}

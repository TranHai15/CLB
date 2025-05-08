<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'to_user_id' => User::factory(), // Đổi từ to_user
            'title' => fake()->sentence(),
            'post_id' => Post::factory(), // Thêm post_id
            'type' => fake()->randomElement(['info', 'success', 'warning', 'error']),
            'is_read' => fake()->boolean(),
        ];
    }
}

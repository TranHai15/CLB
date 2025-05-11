<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        $postId = Post::inRandomOrder()->value('id');
        return [
            'user_id' => $userId,
            'to_user_id' => $userId, // Đổi từ to_user
            'title' => fake()->sentence(),
            'post_id' => $postId, // Thêm post_id
            'type' => fake()->randomElement(['info', 'success', 'warning', 'error']),
            'is_read' => fake()->boolean(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserLike>
 */
class UserLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        $postId = Post::inRandomOrder()->value('id');
        return [
            'user_id' => $userId,
            'post_id' => $postId,
            'type' => fake()->randomElement(['post', 'comment']),
        ];
    }
}

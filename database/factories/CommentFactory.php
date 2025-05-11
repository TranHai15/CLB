<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        $postId = Post::inRandomOrder()->value('id');  // tương tự với post

        return [
            'comment'            => $this->faker->paragraph(),
            'created_by'         => $userId,
            'updated_by'         => $userId,
            'post_id'            => $postId,
            'reply_to_username'  => null,
        ];
    }
}

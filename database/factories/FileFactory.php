<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        $postId = Post::inRandomOrder()->value('id');
        return [
            'created_by' => $userId,
            'storage_path' => 'files/' . fake()->uuid() . '.' . fake()->fileExtension(),
            'fileable_id' => $postId, // Để null ban đầu
            'fileable_type' => $this->faker->randomElement(['post', 'resource', 'user_avatar']), // Để null ban đầu
        ];
    }

    // State để gán file cho Post
    public function forPost(Post $post)
    {
        return $this->state([
            'fileable_id' => $post->id,
            'fileable_type' => Post::class,
        ]);
    }
}

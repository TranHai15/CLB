<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        $categoryId = Category::inRandomOrder()->value('id');
        $title = fake()->sentence();
        return [
            'title' => $title,
            'image' => 'https://hoanghamobile.com/tin-tuc/wp-content/uploads/2024/04/anh-hacker.jpg',
            'slug' => Str::slug($title),
            'type' => fake()->randomElement(['question', 'post']),
            'content' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'views' => fake()->numberBetween(0, 1000),
            'likes' => fake()->numberBetween(0, 1000),
            'created_by' => $userId,
            'updated_by' => $userId,
            'category_id' => $categoryId,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $tags = Tag::factory()->count(3)->create(); // Tạo 3 tags
            $post->tags()->attach($tags); // Gán tags cho bài viết
        });
    }
}

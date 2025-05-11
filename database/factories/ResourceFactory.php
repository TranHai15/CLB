<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Resource;
use App\Models\User;
use App\Models\ResourceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'url' => 'resources/' . fake()->uuid() . '.pdf',
            'status' => fake()->randomElement(['draft', 'published']),
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Resource $resource) {
            $categories = Category::factory()->count(2)->create(); // Tạo 2 categories
            $resource->categories()->attach($categories); // Gán categories
        });
    }
}

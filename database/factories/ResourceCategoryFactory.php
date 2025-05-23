<?php

namespace Database\Factories;

use App\Models\Resource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceCategoryFactory extends Factory
{
    public function definition(): array
    {
        $category_id = Category::inRandomOrder()->value('id');
        return [
            'resource_id' => Resource::factory(),
            'category_id' => $category_id,
        ];
    }
}

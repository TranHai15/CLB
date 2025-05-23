<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $sampleCategories = ['Frontend', 'Backend', 'App', 'SQL', 'NoSQL'];

        $userId = User::inRandomOrder()->value('id'); // lấy ngẫu nhiên 1 user

        foreach ($sampleCategories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'image_url' => fake()->imageUrl(),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }
}

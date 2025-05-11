<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        $name = fake()->unique()->word();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'storage_path' => 'files/' . fake()->uuid() . '.' . fake()->fileExtension(),
            'fileable_id' => fake()->numberBetween(1000, 10000000),
            'fileable_type' => fake()->randomElement(['post', 'resource', 'user_avatar'])
        ];
    }
}

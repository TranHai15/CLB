<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        return [
            'title' => fake()->words(2, true),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now'),
            'end_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['pending', 'ongoing', 'completed']),
            'plan_note' => fake()->paragraph(), // Chuỗi text ngẫu nhiên
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}

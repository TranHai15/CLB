<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        return [
            'title' => fake()->sentence(),
            'plan_id' => Plan::factory(),
            'stt' => fake()->numberBetween(1, 100), // Số nguyên ngẫu nhiên
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now'),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['not_started', 'in_progress', 'completed']),
            'issue_text' => fake()->optional()->sentence(), // Có thể null
            'solution_text' => fake()->optional()->sentence(), // Có thể null
            'evidence_url' => fake()->optional()->url(), // Có thể null
            'created_by' => $userId,
            'assignee_id' => $userId, // Người được giao nhiệm vụ
            'updated_by' => $userId,
        ];
    }
}

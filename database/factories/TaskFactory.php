<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'plan_id' => Plan::factory(),
            'stt' => fake()->randomElement(['1', '2', '3', '4']),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now'),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['not_started', 'in_progress', 'completed']),
            'created_by' => User::factory(),

        ];
    }
}

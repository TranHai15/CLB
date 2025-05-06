<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now'),
            'end_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['pending', 'ongoing']),
            'plan_note' => fake()->randomElement(['monthly', 'yearly']),
            'created_by' => User::factory(),

        ];
    }
}

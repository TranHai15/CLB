<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'type' => fake()->randomElement(['info', 'success', 'warning', 'error']),
            'is_read' => fake()->boolean(),
            'data' => [
                'action' => fake()->randomElement(['post_created', 'comment_added', 'task_assigned']),
                'action_id' => fake()->numberBetween(1, 100),
                'action_by' => fake()->name()
            ]
        ];
    }
}

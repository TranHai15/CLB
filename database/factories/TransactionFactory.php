<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => User::factory(),
            'description' => fake()->sentence(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),

        ];
    }
}

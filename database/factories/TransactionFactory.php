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
            'amount' => fake()->numberBetween(100, 10000), // Số tiền ngẫu nhiên
            'description' => fake()->sentence(),
            'type' => fake()->randomElement(['in', 'out']), // Thêm type
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}

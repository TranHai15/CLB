<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $userId = User::inRandomOrder()->value('id');  // lấy ngẫu nhiên 1 user đang có trong DB
        return [
            'amount' => fake()->numberBetween(100, 10000), // Số tiền ngẫu nhiên
            'description' => fake()->sentence(),
            'type' => fake()->randomElement(['in', 'out']),
            'balance' => fake()->numberBetween(100, 10000),
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}

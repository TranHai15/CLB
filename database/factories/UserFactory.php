<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            'name' => $name,
            'slug' => str_replace('-', '', Str::slug($name)) . rand(1000, 9999),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'avatar_url' => env('DEFAULT_AVATAR'),
            'status' => fake()->randomElement(['active', 'inactive', 'suspended']),
            'student_code' => fake()->unique()->numerify('SV####'),
            'enrollment_year' => fake()->numberBetween(2018, 2024),
            'major' => fake()->randomElement(['Computer Science', 'Information Technology', 'Software Engineering']),
            'phone' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'account_type' => fake()->randomElement(['user', 'club_member']),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowFactory extends Factory
{
    protected $model = Follow::class;

    public function definition(): array
    {
        $follower = User::inRandomOrder()->first();
        $followed = User::inRandomOrder()->where('id', '!=', $follower->id)->first();

        return [
            'user_id' => $follower->id,
            'target_user_id' => $followed->id,
        ];
    }
}

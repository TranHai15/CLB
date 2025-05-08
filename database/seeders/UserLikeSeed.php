<?php

namespace Database\Seeders;

use App\Models\UserLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserLikeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserLike::factory()->count(5)->create();
    }
}

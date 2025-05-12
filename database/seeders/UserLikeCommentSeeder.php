<?php

namespace Database\Seeders;

use App\Models\UserLikeComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserLikeCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserLikeComment::factory()->count(1)->create();
    }
}

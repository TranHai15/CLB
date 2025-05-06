<?php

namespace Database\Seeders;

use App\Models\FacebookContent;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class FacebookContentSeeder extends Seeder
{
    public function run(): void
    {
        // Get all posts and users

        FacebookContent::factory(2)->create();
        // Create facebook contents for each post

    }
}

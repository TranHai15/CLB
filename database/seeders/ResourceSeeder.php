<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users and categories
        Resource::factory(5)->create();
    }
}

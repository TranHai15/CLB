<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create parent categories
        $parentCategories = Category::factory(3)->create();

        // Create child categories for each parent

    }
}

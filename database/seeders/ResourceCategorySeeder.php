<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Category;
use App\Models\ResourceCategory;
use Illuminate\Database\Seeder;

class ResourceCategorySeeder extends Seeder
{
    public function run(): void
    {
        ResourceCategory::factory(5)->create();
    }
}

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
        // Get all resources and categories
        $resources = Resource::all();
        $categories = Category::all();

        // Create resource-category relationships
        foreach ($resources as $resource) {
            // Assign 1-3 random categories to each resource
            $randomCategories = $categories->random(rand(1, 3));
            foreach ($randomCategories as $category) {
                ResourceCategory::create([
                    'resource_id' => $resource->id,
                    'category_id' => $category->id
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            TaskSeeder::class,
            ResourceCategorySeeder::class,
            ResourceSeeder::class,
            FileSeeder::class,
            FacebookContentSeeder::class,
            PlanSeeder::class,
            TransactionSeeder::class,
            NotificationSeeder::class,
            PostTagSeeder::class,
            FactorySeed::class,
            UserLikeSeed::class,
            DepartmentSeed::class,
            UserLikeCommentSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $sampleTags = ['Laravel', 'PHP', 'JavaScript', 'VueJS', 'React', 'TailwindCSS', 'API', 'Tutorial'];

        $userId = User::inRandomOrder()->value('id'); // lấy ngẫu nhiên 1 user

        foreach ($sampleTags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);
        }
    }
}

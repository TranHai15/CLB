<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Get all posts
        $posts = Post::all();

        // Create parent comments for each post
        foreach ($posts as $post) {
            $parentComments = Comment::factory(3)->create([
                'post_id' => $post->id,
                'parent_id' => null
            ]);

            // Create replies for each parent comment
            foreach ($parentComments as $parentComment) {
                Comment::factory(2)->create([
                    'post_id' => $post->id,
                    'parent_id' => $parentComment->id
                ]);
            }
        }
    }
}

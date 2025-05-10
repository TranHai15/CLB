<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with(['creator', 'category', 'tags'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(10);

        $categories = Category::withCount('posts')->get();
        $topPosts = Post::with(['creator'])
            ->latest()
            ->take(5)
            ->get();

        return view('client.home.search', compact('posts', 'categories', 'topPosts', 'category'));
    }
}

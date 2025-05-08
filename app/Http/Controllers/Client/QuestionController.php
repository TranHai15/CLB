<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class QuestionController extends BaseController
{
    public function index()
    {
        // Mock data for questions
        $questions = Post::with('category', 'tags', 'creator')->where('type', 'question')->orderBy('created_at', 'desc')->paginate(10);
        // Mock data for categories
        $categories = Category::all();

        // Mock data for latest posts
        $latestPosts = Post::with('category', 'tags', 'creator')->where('type', 'post')->orderBy('created_at', 'desc')->take(5)->get();


        return view('client.questions.index', compact('questions', 'categories', 'latestPosts'));
    }

    public function create()
    {
        // Sample categories data
        $categories = Category::all();
        $tags = Tag::all();


        return view('client.questions.createQuestions', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'content' => 'required|string'
        ]);
        $slug = Str::slug($validated['title']);
        $post = new Post();
        $post->title = $validated['title'];
        $post->slug = $slug;
        $post->category_id = $validated['category_id'];
        $post->content = $validated['content'];
        $post->type = 'question';
        $post->created_by = Auth::id();
        $post->save();

        // Here you would typically save the question to the database
        // For now, we'll just redirect back with a success message
        return redirect()->back()->with('success', 'Câu hỏi đã được đăng thành công!');
    }

    public function show(Post $post)
    {
        // Tăng lượt xem
        $post->increment('views');

        // Eager-load creator, category, và cả comments + creator của comments
        $post->load([
            'creator',
            'category',
            'comments.creator'
        ]);
        // Lấy câu hỏi liên quan
        $relatedQuestions = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('type', 'question')
            ->take(5)
            ->get();

        if ($relatedQuestions->isEmpty()) {
            $relatedQuestions = Post::where('type', 'question')
                ->where('id', '!=', $post->id)
                ->latest() // tương đương với orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('client.questions.show', [
            'question' => $post,
            'relatedQuestions' => $relatedQuestions,
        ]);
    }
}

<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Post;
// use App\Models\Category;
// use App\Models\Tag;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;

// class PostController extends Controller
// {
//     public function index()
//     {
//         $posts = Post::with(['category', 'tags', 'creator'])
//             ->orderBy('created_at', 'desc')
//             ->paginate(10);

//         return view('admin.posts.index', compact('posts'));
//     }

//     public function create()
//     {
//         $categories = Category::all();
//         $tags = Tag::all();

//         return view('admin.posts.create', compact('categories', 'tags'));
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'title' => 'required|string|max:255',
//             'content' => 'required|string',
//             'category_id' => 'required|exists:categories,id',
//             'tag_ids' => 'nullable|array',
//             'tag_ids.*' => 'exists:tags,id',
//             'status' => 'required|in:draft,published,archived'
//         ]);

//         $post = Post::create([
//             'title' => $validated['title'],
//             'slug' => Str::slug($validated['title']) . '-' . Str::random(5),
//             'content' => $validated['content'],
//             'status' => $validated['status'],
//             'created_by' => Auth::id(),
//             'updated_by' => Auth::id(),
//             'category_id' => $validated['category_id']
//         ]);

//         if (isset($validated['tag_ids'])) {
//             $post->tags()->sync($validated['tag_ids']);
//         }

//         return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được tạo thành công!');
//     }

//     public function show(Post $post)
//     {
//         $post->load(['category', 'tags', 'creator']);
//         return view('admin.posts.show', compact('post'));
//     }

//     public function edit(Post $post)
//     {
//         $categories = Category::all();
//         $tags = Tag::all();

//         $post->load(['category', 'tags']);

//         return view('admin.posts.edit', compact('post', 'categories', 'tags'));
//     }

//     public function update(Request $request, Post $post)
//     {
//         $validated = $request->validate([
//             'title' => 'required|string|max:255',
//             'content' => 'required|string',
//             'category_id' => 'required|exists:categories,id',
//             'tag_ids' => 'nullable|array',
//             'tag_ids.*' => 'exists:tags,id',
//             'status' => 'required|in:draft,published,archived'
//         ]);

//         $post->update([
//             'title' => $validated['title'],
//             'content' => $validated['content'],
//             'status' => $validated['status'],
//             'updated_by' => Auth::id(),
//             'category_id' => $validated['category_id']
//         ]);

//         if (isset($validated['tag_ids'])) {
//             $post->tags()->sync($validated['tag_ids']);
//         } else {
//             $post->tags()->detach();
//         }

//         return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được cập nhật thành công!');
//     }

//     public function destroy(Post $post)
//     {
//         $post->tags()->detach();
//         $post->delete();

//         return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được xóa thành công!');
//     }

//     public function toggleStatus(Post $post)
//     {
//         $newStatus = $post->status === 'published' ? 'draft' : 'published';
//         $post->update(['status' => $newStatus]);

//         return redirect()->back()->with('success', 'Đã thay đổi trạng thái bài viết!');
//     }
// }

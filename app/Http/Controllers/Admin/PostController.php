<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with(['creator', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type'        => 'required|in:post,question',
            'status'      => 'required|in:draft,published,archived',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        // Tạo slug duy nhất
        $slug  = Str::slug($validated['title']);
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['title']) . '-' . $count++;
        }

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $folder = 'posts'; // Thư mục lưu trữ trong disk 'public'

            // Kiểm tra và tạo thư mục nếu chưa tồn tại
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            $image    = $request->file('image');
            $filename = 'post-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/' . $folder, $filename);

            // Đường dẫn truy cập từ trình duyệt
            $imagePath = '/storage/' . $folder . '/' . $filename;
        }

        // Tạo bài viết mới
        $post = Post::create([
            'title'       => $validated['title'],
            'slug'        => $slug,
            'content'     => $validated['content'],
            'category_id' => $validated['category_id'],
            'image'       => $imagePath,
            'type'        => $validated['type'],
            'status'      => $validated['status'],
            'views'       => 0,
            'likes'       => 0,
            'created_by'  => Auth::id(),
            'updated_by'  => Auth::id(),
        ]);

        // Gắn thẻ (tags) nếu có
        if (!empty($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được tạo thành công.');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        $post->load(['creator', 'updater', 'category', 'tags']);

        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post->load('tags');

        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:post,question',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Update slug if title changed
        if ($post->title !== $validated['title']) {
            $slug = Str::slug($validated['title']);
            $count = 1;

            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = Str::slug($validated['title']) . '-' . $count++;
            }

            $post->slug = $slug;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && Storage::exists('public' . str_replace('/storage', '', $post->image))) {
                Storage::delete('public' . str_replace('/storage', '', $post->image));
            }

            $image = $request->file('image');
            $filename = 'post-' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/posts', $filename);
            $post->image = '/storage/posts/' . $filename;
        }

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->category_id = $validated['category_id'];
        $post->type = $validated['type'];
        $post->status = $validated['status'];
        $post->updated_by = Auth::id();
        $post->save();

        // Sync tags
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        // Delete image if exists
        if ($post->image && Storage::exists('public' . str_replace('/storage', '', $post->image))) {
            Storage::delete('public' . str_replace('/storage', '', $post->image));
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }

    /**
     * Toggle the status of the specified post.
     */
    public function toggleStatus(Post $post)
    {
        if ($post->status === 'published') {
            $post->status = 'archived';
        } else {
            $post->status = 'published';
        }

        $post->updated_by = Auth::id();
        $post->save();

        return back()->with('success', 'Trạng thái bài viết đã được cập nhật.');
    }
}

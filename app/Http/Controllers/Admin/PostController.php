<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Http;
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

        $folder = 'uploads/posts';
        // Kiểm tra nếu thư mục chưa tồn tại thì tạo mới
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true); // 0755 là quyền truy cập, true để tạo cả thư mục cha nếu cần
        }
        $image = $request->file('image');
        $filename = 'post-' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($folder), $filename);

        // 3. Cập nhật URL avatar
        $imagePath = '/' . $folder . '/' . $filename;

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

        $apiKey = 'AIzaSyAyx8wMLqp6YYzTMFPkQAu0VINA9HGwbGI'; // Thay YOUR_API_KEY bằng khóa API của bạn
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $data = [
            "system_instruction" => [
                "parts" => [
                    [
                        "text" => "Tên của bạn là Bee IT. Bạn là trợ lí ảo của câu lạc bộ Bee IT của trường Cao đẳng FPT Polytechnic"
                    ]
                ]
            ],
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => "Viết 1 bài post, giữ nguyên thông tin của bài viết cho tôi. Đưa ra dữ liệu ở dạng normal text giống viết văn, không được đưa ra ở dạng markdown: ". $validated['content']
                        ]
                    ]
                ]
            ]
        ];
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        $result = json_decode($response, true); // Decode chuỗi JSON thành mảng
            // echo "Response: \n";
        curl_close($ch);
        $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response text found';
        $url = "https://graph.facebook.com/v22.0/109867448827091/feed";

        if ($content == "No response text found"){

        } else {
        $response = Http::post($url, [
            'message' => $content . "\n—----------------------------------------------------------------------------
BEE IT CLUB - Code hard, play harder
Facebook: https://www.facebook.com/Bee.IT.Fpoly
Community: https://zalo.me/g/gcqslb945 (Zalo)
Email: Beeit.fpoly@gmail.com
Lịch hỗ trợ học tập: Tối thứ 3&5 hàng tuần
—-----------------------------------------------------------------------------",
            'published'=>True,
            'access_token' => "EAAjABRz9GMgBO6M5LQRwZBIWiZBZBq0i7ZCkm2bBLWCkMnZCgHEnGSGprq5LjvDZBewvX06BAKBMKSZCMSB0w4SvJscB3cUIcUC9yPo72lAOTHKeHQ6vgSLS7xyRloaXhmqoPvHUo1JJWwFvmVUoDzLr7c4rZCHyt9UrAQFJdMfKtD0MlTd7au92T8q7CxMZD",
        ]);
        }


        // Http()
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

        if ($request->hasFile('image')) {
            $folder = 'uploads/posts';

            // 1. Xóa avatar cũ nếu có
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }

            // 2. Lưu file mới
            $image = $request->file('image');
            $filename = 'post-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($folder), $filename);

            // 3. Cập nhật URL avatar
            $post->image = '/' . $folder . '/' . $filename;
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

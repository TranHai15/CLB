<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    public function index()
    {
        // Lấy top 5 bài viết mới nhất
        $topPosts = Post::with(['creator', 'category'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Lấy danh sách bài viết với thông tin chi tiết
        $posts = Post::with(['creator', 'category', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Lấy danh sách categories
        $categories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        return view('client.home.home', compact('topPosts', 'posts', 'categories'));
    }

    public function blog()
    {
        // Lấy top 5 bài viết mới nhất
        $topPosts = Post::with(['creator', 'category', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Lấy danh sách bài viết với thông tin chi tiết
        $posts = Post::with(['creator', 'category', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Lấy danh sách categories
        $categories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        // Lấy thông báo

        return view('client.home.blog', compact('topPosts', 'posts', 'categories'));
    }

    public function show(Post $post)
    {
        $post->load(['creator', 'category', 'tags', 'comments.creator']);

        // Tăng lượt xem
        $post->increment('views');

        // Kiểm tra xem người dùng đã like bài viết chưa
        if (Auth::check()) {
            $post->is_liked = DB::table('user_likes')
                ->where('user_id', Auth::id())
                ->where('post_id', $post->id)
                ->exists();
        }

        // Lấy bài viết liên quan
        $relatedPosts = Post::with(['creator', 'category'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Nếu không có bài viết liên quan thì lấy 4 bài viết có lượt xem nhiều nhất (trừ bài hiện tại)
        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::with(['creator', 'category'])
                ->where('id', '!=', $post->id)
                ->orderByDesc('views')
                ->take(4)
                ->get();
        }

        return view('client.post.post', compact('post', 'relatedPosts'));
    }


    public function createPost()
    {
        // Lấy danh sách categories
        $categories = Category::all();

        // Lấy thông báo
        $notifications = Notification::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $unreadNotifications = $notifications->where('read', false)->count();
        $latestNotifications = $notifications->take(5);

        return view('client.post.createPost', compact('categories', 'unreadNotifications', 'latestNotifications'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function uploadImage(Request $request)
    {
        try {
            // File Route.
            $fileRoute = "/uploads/image";
            $fieldname = "image_params";

            // Get filename.
            $filename = explode(".", $_FILES[$fieldname]["name"]);

            // Validate uploaded files.
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $tmpName = $_FILES[$fieldname]["tmp_name"];
            $mimeType = finfo_file($finfo, $tmpName);
            $extension = end($filename);

            // Allowed extensions.
            $allowedExts = array("jpg", "jpeg", "png", "gif", "mp4", "webm", "ogg");
            $allowedMimeTypes = array("image/jpeg", "image/png", "image/gif", "video/mp4", "video/webm", "video/ogg");

            // Validate file.
            if (!in_array(strtolower($mimeType), $allowedMimeTypes) || !in_array(strtolower($extension), $allowedExts)) {
                throw new \Exception("File does not meet the validation.");
            }

            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;
            $destinationPath = public_path($fileRoute);

            // Check server protocol
            $protocol = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off" ? "https://" : "http://";

            // Create directory if not exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Move file
            $fullNamePath = $destinationPath . '/' . $name;
            if (move_uploaded_file($tmpName, $fullNamePath)) {
                $response = new \StdClass;
                $response->link = $protocol . $_SERVER['HTTP_HOST'] . $fileRoute . '/' . $name;
                echo stripslashes(json_encode($response));
            } else {
                throw new \Exception("Không thể di chuyển file.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(404);
        }
    }

    public function notifications()
    {
        $notifications = Notification::with(['receiver', 'sender', 'post'])
            ->where('to_user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $collection = collect($notifications->items());

        return view('client.notifications.index', [
            'notifications'        => $notifications,
            'totalNotifications'   => $notifications->total(),
            'unreadCount'          => $collection->where('read', false)->count(),
            'readCount'            => $collection->where('read', true)->count(),
            'unreadNotifications'  => $collection->where('read', false)->count(),
            'latestNotifications'  => $collection->take(5),
        ]);
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->paginate(10);
        return view('client.home.search', compact('category', 'posts'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()->paginate(10);
        return view('client.home.search', compact('tag', 'posts'));
    }

    public function user(User $user)
    {
        // Load user's questions with relationships
        $questions = $user->posts()
            ->where('type', 'question')
            ->with(['category', 'tags', 'creator'])
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        // Get following and followers
        $following = $user->follows()->get();
        $followers = $user->followedBy()->get();

        // Get user's statistics
        $user->questions_count = $user->posts()->where('type', 'question')->count();
        $user->following_count = $following->count();
        $user->followers_count = $followers->count();

        return view('client.home.profile', compact('user', 'questions', 'following', 'followers'));
    }

    public function search(Request $request)
    {
        // Get all published posts with relationships
        $posts = Post::with(['creator', 'category', 'tags'])
            ->where('status', 'published')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Get categories for filter
        $categories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        return view('client.home.search', compact('posts', 'categories'));
    }

    public function follow(User $user)
    {
        // Không cho phép tự theo dõi chính mình
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Bạn không thể theo dõi chính mình.');
        }

        // Kiểm tra xem đã theo dõi chưa
        if (!Auth::user()->follows()->where('target_user_id', $user->id)->exists()) {
            Auth::user()->follows()->attach($user->id);
            return back()->with('success', 'Đã theo dõi ' . $user->name);
        }

        return back()->with('info', 'Bạn đã theo dõi người dùng này.');
    }

    public function unfollow(User $user)
    {
        // Không cho phép tự hủy theo dõi chính mình
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Không thể thực hiện thao tác này.');
        }

        // Kiểm tra xem đã theo dõi chưa
        if (Auth::user()->follows()->where('target_user_id', $user->id)->exists()) {
            Auth::user()->follows()->detach($user->id);
            return back()->with('success', 'Đã hủy theo dõi ' . $user->name);
        }

        return back()->with('info', 'Bạn chưa theo dõi người dùng này.');
    }
}

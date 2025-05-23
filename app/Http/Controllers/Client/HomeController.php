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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Artesaos\SEOTools\Facades\SEOTools;



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

        // Sử dụng SEOTools facade (tất cả trong một)
        SEOTools::setTitle('Trang chủ');
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        return view('client.home.home', compact('topPosts', 'posts', 'categories'));
    }
    public function meb()
    {
        return view('client.home.member');
    }
    public function storeMembers(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'student_code' => 'required|string|max:100|unique:users,student_code',
            'enrollment_year' => 'required|string|max:20',
            'major' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // Thêm các giá trị mặc định
        $validated['account_type'] = 'club_member';  // Mặc định là club_member
        $validated['status'] = 'inactive';           // Mặc định là inactive
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['avatar_url'] = env('DEFAULT_AVATAR');

        // Tạo mật khẩu mặc định hoặc tự động



        // Tạo user mới
        $user = User::create($validated);

        // Thông báo thành công và quay lại trang danh sách
        return redirect()->route(route: 'home')
            ->with('success', 'Thêm thành viên thành công!');
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
        SEOTools::setTitle('Blog');
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
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
        SEOTools::setTitle($post->title);
        SEOTools::setDescription(Str::limit(strip_tags($post->content), 160));
        SEOTools::opengraph()->setUrl(route('questions.show', $post->slug));
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage($post->image ?? 'https://example.com/default.jpg');
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
        SEOTools::setTitle('Create Post');
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
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
        SEOTools::setTitle($category->slug);
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        return view('client.home.search', compact('category', 'posts'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()->paginate(10);
        SEOTools::setTitle($tag->slug);
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
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
        SEOTools::setTitle($user->slug);
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
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

        SEOTools::setTitle($posts->slug ?? "");
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
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

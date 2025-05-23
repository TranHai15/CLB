<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\DB;


class QuestionController extends BaseController
{
    public function index()
    {
        // Mock data for questions
        $questions = Post::with('category', 'tags', 'creator')->where('type', 'question')->orderBy('created_at', 'desc')->paginate(10);
        // Mock data for categories
        $categories = Category::all();
        $tags = Tag::all();
        // Mock data for latest posts
        $latestPosts = Post::with('category', 'tags', 'creator')->where('type', 'post')->orderBy('created_at', 'desc')->take(5)->get();
        SEOTools::setTitle('Question');
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');

        return view('client.questions.index', compact('questions', 'categories', 'latestPosts', 'tags'));
    }

    public function create()
    {
        // Sample categories data
        $categories = Category::all();
        $tags = Tag::all();

        SEOTools::setTitle('Create Question');
        SEOTools::setDescription('Bee IT, Bee IT là một cộng đồng năng động, nơi các bạn có thể giao lưu, học hỏi và chia sẻ kiến thức trong lĩnh vực CNTT');
        SEOTools::opengraph()->setUrl('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        SEOTools::jsonLd()->addImage('https://scontent.fhan14-5.fna.fbcdn.net/v/t39.30808-1/356893364_106371362513103_5755489272171968894_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=y-rWDAO1JhkQ7kNvwEL5pMk&_nc_oc=AdmbyNCqso5lMur4PBbecz7nq_s6hy-XkqCcrKiM1NzoQn0h0cy5oOGy83mh8QS7aR2xV7H6-tCwc4VYwjbMnIOD&_nc_zt=24&_nc_ht=scontent.fhan14-5.fna&_nc_gid=V8zWbWTW1M8DbSK9kgI-lg&oh=00_AfL1IFzTjMADLGfzHAC5qVrFh8e7gN1HIbLnrhSkMh44Pw&oe=683694C5');
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

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }
        // Chuyển hướng đến trang chi tiết câu hỏi vừa tạo
        return redirect()->route('questions.show', $post->slug)
            ->with('success', 'Câu hỏi đã được đăng thành công!');
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
        SEOTools::setTitle($post->title);
        SEOTools::setDescription(Str::limit(strip_tags($post->content ?? "question"), 160));
        SEOTools::opengraph()->setUrl(route('questions.show', $post->slug));
        SEOTools::opengraph()->addProperty('type', 'question');
        // SEOTools::twitter()->setSite('@YourTwitterHandle');
        // SEOTools::jsonLd()->addImage($post->image ?? 'https://example.com/default.jpg');
        return view('client.questions.show', [
            'question' => $post,
            'relatedQuestions' => $relatedQuestions,
        ]);
    }

    public function edit(Post $post)
    {
        // Kiểm tra quyền chỉnh sửa
        if (Auth::id() !== $post->creator->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa câu hỏi này');
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('client.questions.edit', [
            'question' => $post,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function update(Request $request,  $id)
    {
        // Kiểm tra quyền chỉnh sửa
        $post = Post::with('creator')->where('slug', $id)->first();
        if (Auth::id() !== $post->creator->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa câu hỏi này');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'content' => 'required|string'
        ]);

        $post->title = $validated['title'];
        $post->slug = Str::slug($validated['title']);
        $post->category_id = $validated['category_id'];
        $post->content = $validated['content'];
        $post->save();

        // Cập nhật tags
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('questions.show', $post->slug)
            ->with('success', 'Câu hỏi đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $post = Post::with('creator')->find($id);
        // Kiểm tra quyền xóa
        if (Auth::id() !== $post->creator->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa câu hỏi này'
            ], 403);
        }

        try {
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Câu hỏi đã được xóa thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa câu hỏi'
            ], 500);
        }
    }
}

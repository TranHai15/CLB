<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);

        // Sử dụng bảng user_likes để lưu thông tin người dùng đã like bài viết nào
        $isLiked = DB::table('user_likes')
            ->where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->exists();

        if ($isLiked) {
            // Đã like, giờ unlike
            DB::table('user_likes')
                ->where('user_id', Auth::id())
                ->where('post_id', $post->id)
                ->delete();

            // Giảm số lượt like trong bảng posts
            $post->decrement('likes');
            $message = 'Đã bỏ thích bài viết';
            $liked = false;
        } else {
            // Chưa like, giờ like
            DB::table('user_likes')->insert([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tăng số lượt like trong bảng posts
            $post->increment('likes');
            $message = 'Đã thích bài viết';
            $liked = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'likes' => $post->likes,
                'liked' => $liked
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleCommentLike(Comment $comment)
    {
        // Sử dụng bảng user_comment_likes để lưu thông tin người dùng đã like bình luận nào

        $isLiked = DB::table('user_likes')
            ->where('user_id', Auth::id())
            ->where('post_id', $comment->post_id)
            ->exists();

        if ($isLiked) {
            // Đã like, giờ unlike
            DB::table('user_likes')
                ->where('user_id', Auth::id())
                ->where('post_id', $comment->post_id)
                ->delete();

            // Giảm số lượt like trong bảng comments
            $comment->decrement('like_count');
            $message = 'Đã bỏ thích bình luận';
            $liked = false;
        } else {
            // Chưa like, giờ like
            DB::table('user_likes')->insert([
                'user_id' => Auth::id(),
                'post_id' => $comment->post_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tăng số lượt like trong bảng comments
            $comment->increment('like_count');
            $message = 'Đã thích bình luận';
            $liked = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'likes' => $comment->like_count,
                'liked' => $liked
            ]);
        }

        return back()->with('success', $message);
    }
}

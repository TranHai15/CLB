<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->created_by = Auth::id();
        $comment->save();

        return back()->with('success', 'Bình luận đã được gửi thành công');
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $reply = new Comment();
        $reply->post_id = $comment->post_id;
        $reply->parent_id = $comment->id;
        $reply->comment = $request->comment;
        $reply->created_by = Auth::id();
        $reply->save();

        return back()->with('success', 'Phản hồi đã được gửi thành công');
    }

    public function update(Request $request, Comment $comment)
    {
        // Check if the user is authorized to update the comment
        if (Auth::id() !== $comment->created_by) {
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này');
        }

        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->comment = $request->comment;
        $comment->updated_by = Auth::id();
        $comment->save();

        return back()->with('success', 'Bình luận đã được cập nhật');
    }

    public function destroy(Comment $comment)
    {
        // Check if the user is authorized to delete the comment
        if (Auth::id() !== $comment->created_by) {
            return back()->with('error', 'Bạn không có quyền xóa bình luận này');
        }

        $comment->delete();

        return back()->with('success', 'Bình luận đã được xóa');
    }
}

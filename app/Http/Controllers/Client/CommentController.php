<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $post = Post::find($id);
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->comment = $request->comment;
        $comment->created_by = Auth::id();
        $comment->save();

        // Reload the comment with its relationships
        $comment = Comment::with('creator')->find($comment->id);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được gửi thành công',
                'comment' => $comment,
                'user' => Auth::user(),
                'html' => view('client.partials.comment', compact('comment'))->render()
            ]);
        }

        return back()->with('success', 'Bình luận đã được gửi thành công');
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Get the username of the comment creator we're replying to
        $replyToUser = $comment->creator->slug;

        // Add the @username mention to the beginning of the comment
        $commentText = '@' . $replyToUser . ' ' . $request->comment;

        $reply = new Comment();
        $reply->post_id = $comment->post_id;
        $reply->reply_to_username = $replyToUser;
        $reply->comment = $commentText;
        $reply->created_by = Auth::id();
        $reply->save();

        // Reload the reply with its relationships
        $reply = Comment::with('creator')->find($reply->id);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Phản hồi đã được gửi thành công',
                'comment' => $reply,
                'html' => view('client.partials.comment', ['comment' => $reply])->render()
            ]);
        }

        return back()->with('success', 'Phản hồi đã được gửi thành công');
    }

    public function update(Request $request, Comment $comment)
    {
        // Check if the user is authorized to update the comment
        if (Auth::id() !== $comment->created_by) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền chỉnh sửa bình luận này'
                ], 403);
            }
            return back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này');
        }

        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->comment = $request->comment;
        $comment->updated_by = Auth::id();
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được cập nhật',
                'comment' => $comment
            ]);
        }

        return back()->with('success', 'Bình luận đã được cập nhật');
    }

    public function destroy(Comment $comment)
    {
        // Check if the user is authorized to delete the comment
        if (Auth::id() !== $comment->created_by) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa bình luận này'
                ], 403);
            }
            return back()->with('error', 'Bạn không có quyền xóa bình luận này');
        }

        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được xóa'
            ]);
        }

        return back()->with('success', 'Bình luận đã được xóa');
    }
}

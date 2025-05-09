<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = Comment::with(['post', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment)
    {
        $comment->load(['post', 'creator']);
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')
            ->with('success', 'Bình luận đã được xóa thành công.');
    }
}

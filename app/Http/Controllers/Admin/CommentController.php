<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        // Debug: Check raw data
        $rawComments = DB::table('comments')->get();


        // Debug: Check model data
        $comments = Comment::with(['creator', 'post'])
            ->latest()
            ->paginate(10);


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

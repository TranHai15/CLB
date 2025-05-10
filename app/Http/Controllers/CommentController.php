<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function destroy(Comment $comment)
    {
        // Kiểm tra quyền xóa
        if (auth()->id() !== $comment->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa bình luận này'
            ], 403);
        }

        try {
            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa bình luận thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa bình luận'
            ], 500);
        }
    }
}

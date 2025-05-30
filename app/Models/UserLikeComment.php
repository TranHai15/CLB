<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLikeComment extends Model
{
    /** @use HasFactory<\Database\Factories\UserLikeCommentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'comment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}

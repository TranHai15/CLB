<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacebookContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prompt',
        'content',
        'image_url',
        'created_by',
        'updated_by',

    ];

    protected $casts = [];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

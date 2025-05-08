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
        'updated_by'
    ];

    protected $casts = [];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

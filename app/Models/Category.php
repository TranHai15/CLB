<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'image_url',
        'created_by',
        'updated_by'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_categories');
    }
}

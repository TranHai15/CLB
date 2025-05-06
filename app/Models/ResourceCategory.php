<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resource_id',
        'category_id'
    ];

    // Relationships
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(ResourceCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ResourceCategory::class, 'parent_id');
    }
}

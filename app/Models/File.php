<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'storage_path',
        'created_by'
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fileable()
    {
        return $this->morphTo();
    }
    public function metadata()
    {
        return $this->hasOne(FileMetadata::class, 'file_id');
    }
}

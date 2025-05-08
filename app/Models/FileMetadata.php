<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileMetadata extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_id',
        'original_name',
        'checksum',
        'mime_type',
        'file_size'
    ];

    protected $casts = [
        'file_size' => 'integer',

    ];

    // Relationships
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}

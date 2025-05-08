<?php

namespace App\Models;

use App\Models\User;             // ← thêm dòng này
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follows';

    protected $fillable = [
        'user_id',
        'target_user_id',
    ];

    public function follower()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}

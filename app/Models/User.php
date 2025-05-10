<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'google_id',
        'name',
        'slug',
        'email',
        'avatar_url',
        'status',
        'email_verified_at',
        'student_code',
        'enrollment_year',
        'major',
        'phone',
        'gender',
        'account_type',
        'remember_token',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];
    public function getRouteKeyName()
    {
        return 'slug'; // Laravel sẽ dùng 'slug' thay vì 'id'
    }


    // Người mà tôi đang theo dõi


    // Người đang theo dõi tôi
    public function followedBy()
    {
        return $this->belongsToMany(User::class, 'follows', 'target_user_id', 'user_id');
    }

    // Người mà tôi đang theo dõi
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'target_user_id');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'created_by');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'created_by');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'created_by');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'created_by');
    }

    public function tasksCreated()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function tasksAssigned()
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'created_by');
    }

    public function notificationsSent()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function notificationsReceived()
    {
        return $this->hasMany(Notification::class, 'to_user_id');
    }
}

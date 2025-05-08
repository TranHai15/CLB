<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plan_id',
        'stt',
        'title',
        'description',
        'start_date',
        'due_date',
        'status',
        'issue_text',
        'solution_text',
        'evidence_url',
        'created_by',
        'assignee_id',
        'updated_by'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Relationships
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

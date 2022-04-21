<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Request extends BaseModel
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'name',
        'content',
        'status',
        'priority_id',
        'category_id',
        'created_by',
        'updated_by',
        'approve_id',
        'assignee_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'due_date',
    ];

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function approveBy()
    {
        return $this->belongsTo(User::class, 'approve_id', 'id');
    }

    public function assigneeId()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'comments', 'request_id', 'created_by')
                    ->withPivot('content')->withTimestamps();
    }

    public function filterName($query, $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }

    public function filterContent($query, $value)
    {
        return $query->where('content', 'LIKE', '%' . $value . '%');
    }

    public function filterCreatedAt($query, $value)
    {
        return $query->whereDate('created_at', '>=', $value);
    }

    public function filterStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    public function filterAssigneeId($query, $value)
    {
        return $query->where('assignee_id', $value);
    }

    public function filterCategoryId($query, $value)
    {
        return $query->where('category_id', $value);
    }

    public function filterCreatedBy($query, $value)
    {
        return $query->where('created_by', $value);
    }

    public function filterPriorityId($query, $value)
    {
        return $query->where('priority_id', $value);
    }
}

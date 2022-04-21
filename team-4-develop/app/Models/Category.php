<?php

namespace App\Models;

use App\Models\Enums\Category as EnumsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'assignee',
        'created_by',
        'status',
        'updated_by',
    ];

    public function request()
    {
        return $this->HasMany(Request::class, 'category_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'assignee', 'id');
    }

    public function scopeActive($query, $active)
    {
        $query->where('status', $active);
    }
}

<?php

namespace App\Models;

use App\Models\Enums\Department as EnumsDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Department extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status'
    ];

    public function user()
    {
        return $this->HasMany(User::class, 'department_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', EnumsDepartment::ACTIVE);
    }
}

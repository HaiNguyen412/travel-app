<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'code',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function blogSubjects()
    {
        return $this->hasMany(BlogSubject::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'content',
        'blog_comments_id',
        'author_id',
        'blog_id',
        'status',
        'like_total',
        'dislike_total',
        'comment_total',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

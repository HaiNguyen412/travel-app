<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'content',
        'author_id',
        'status',
        'like_total',
        'dislike_total',
        'comment_total',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    // RELATIONs

    /**
     * Get the post's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // MUTATORs

    /**
     * Get the user's most recent image.
     */
    public function latestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->latestOfMany();
    }

//    /**
//     * Get the user's most popular image.
//     */
//    public function bestImage()
//    {
//        return $this->morphOne(Image::class, 'imageable')->ofMany('likes', 'max');
//    }
}

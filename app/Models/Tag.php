<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path',
    ];


    // RELATIONs
    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Blog::class, 'taggable');
    }

//    /**
//     * Get all of the videos that are assigned this tag.
//     */
//    public function videos()
//    {
//        return $this->morphedByMany(Video::class, 'taggable');
//    }


    // MUTATORs
}

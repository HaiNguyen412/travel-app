<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'path'
    ];

    /**
     * Get the parent imageable model (user or post for example).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}

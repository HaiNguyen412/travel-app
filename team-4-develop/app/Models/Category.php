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
        'description',
        'code',
        'name',
        'created_by',
        'updated_by',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogSubject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'category_id',
        'area_id',
        'country_id',
        'province_id',
        'city_id',
        'district_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}

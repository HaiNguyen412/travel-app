<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use HasFactory;

    protected static function boot()
    {

        parent::boot();

        $userId = Auth::user() ? Auth::user()->id : 1;

        static::updating(function ($model) use ($userId) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $userId;
            }
        });

        static::creating(function ($model) use ($userId) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $userId;
            }
            if (!$model->isDirty('created_by')) {
                $model->created_by = $userId;
            }
        });
    }
}

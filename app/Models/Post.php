<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('is_published', 1);
    }

    public function getImageUrlAttribute()
    {
        return Storage::disk('documents')
            ->url($this->image);
    }
}

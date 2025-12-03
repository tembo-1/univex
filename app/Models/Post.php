<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $guarded = [];

    public function getPublishedAtAttribute()
    {
        return $this->created_at?->translatedFormat('j F Y');
    }

    public function getImageUrlAttribute()
    {
        return Storage::disk('documents')
            ->url($this->image);
    }
}

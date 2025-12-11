<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteElementImage extends Model
{
    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        return Storage::disk('documents')
            ->url($this->image);
    }
}

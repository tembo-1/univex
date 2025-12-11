<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SitePage extends Model
{
    protected $guarded = [];

    public function siteBlocks(): HasMany
    {
        return $this->hasMany(SiteBlock::class);
    }
}

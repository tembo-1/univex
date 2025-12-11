<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteBlock extends Model
{
    protected $guarded = [];

    public function siteElements(): HasMany
    {
        return $this->hasMany(SiteElement::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function sitePage()
    {
        return $this->belongsTo(SitePage::class);
    }
}

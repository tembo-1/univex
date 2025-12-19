<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubstitution extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function substitute()
    {
        return $this->belongsTo(Product::class, 'substitute_id');
    }
}

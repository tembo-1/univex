<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';
    protected $guarded = [];

    public function getCleanNameAttribute()
    {
        if (auth()->check()) {
            return $this->name;
        }

        return 'Есть в наличии';
    }
}

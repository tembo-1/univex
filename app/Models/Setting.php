<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $guarded = [];

    public function scopeWithPrefix($query, string $prefix)
    {
        return $query->where('key', 'like', $prefix . '_%');
    }

    public static function getByPrefix(string $prefix)
    {
        return static::withPrefix($prefix)
            ->get();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    protected $guarded = [];

    public function callbackType()
    {
        return $this->belongsTo(CallbackType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notepad extends Model
{
    protected $guarded = [];

    public function notepadItems(): HasMany
    {
        return $this->hasMany(NotepadItem::class);
    }
}

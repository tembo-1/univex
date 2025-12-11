<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $guarded = [];

    public function catalogFiles()
    {
        return $this->hasMany(CatalogFile::class);
    }
}

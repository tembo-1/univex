<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MailingType extends Model
{
    protected $guarded = [];

    public function mailingCampaigns(): HasMany
    {
        return $this->hasMany(MailingCampaign::class);
    }
}

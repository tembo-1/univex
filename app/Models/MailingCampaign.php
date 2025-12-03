<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MailingCampaign extends Model
{
    protected $guarded = [];

    public function mailingStatus(): BelongsTo
    {
        return $this->belongsTo(MailingStatus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mailingRecipients(): HasMany
    {
        return $this->hasMany(MailingRecipients::class);
    }

    public function getRecipientsCountAttribute()
    {
        return $this->send_to_all
            ? 'Всем'
            : $this->mailingRecipients()->count();
    }
}

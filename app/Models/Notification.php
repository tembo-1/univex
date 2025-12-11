<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notification extends Model
{
    protected $guarded = [];

    public function notificationRecipientGroup(): BelongsTo
    {
        return $this->belongsTo(NotificationRecipientGroup::class);
    }

    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function notificationRecipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class);
    }

    public static function countActive()
    {
        return self::query()
            ->active()
            ->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>', now());
            })
            ->where(function($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            });
    }

    public function getRecipientsCountAttribute(): int
    {
        return $this->notificationRecipients()->count();
    }

    public function getColorAttribute()
    {
        return match($this->notification_type_id) {
            1 => '#1998f2', // info - синий
            2 => '#2ecc71', // success - зеленый
            3 => '#f39c12', // warning - оранжевый
            4 => '#e74c3c', // error - красный
            default => '#1998f2',
        };
    }
}

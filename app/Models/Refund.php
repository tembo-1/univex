<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Refund extends Model
{
    protected $guarded = [];

    public function refundStatus(): BelongsTo
    {
        return $this->belongsTo(RefundStatus::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function refundItems(): HasMany
    {
        return $this->hasMany(RefundItem::class);
    }

    public function refundConversations(): HasMany
    {
        return $this->hasMany(RefundConversation::class);
    }

    // Accessors

    public function getClientNameAttribute(): string
    {
        return $this->order->user->client->short_name;
    }

    public function getRefundItemsCountAttribute(): string
    {
        return $this->refundItems()->count();
    }

    public function getQuantityAttribute(): int
    {
        return $this->refundItems()->sum('quantity');
    }

    public function getOrderShippingTypeNameAttribute(): string
    {
        return $this->order->shippingType->name;
    }

    public function getOrderShippingAddressAttribute(): string
    {
        return $this->order->shipping_address;
    }

    public function getOrderIsPaidAttribute(): bool
    {
        return $this->order->is_paid;
    }

    public function getTotalAmountAttribute(): int
    {
        return $this->refundItems->sum(function ($refundItem) {
            return $refundItem->quantity * $refundItem->orderItem->unit_price;
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundItem extends Model
{
    protected $guarded = [];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function refundType(): BelongsTo
    {
        return $this->belongsTo(RefundType::class);
    }

    public function getTotalAmountAttribute(): int
    {
        return ($this->orderItem->unit_price * $this->quantity) / 100.0;
    }
}

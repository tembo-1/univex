<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $guarded = [];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function warehouseProducts(): HasMany
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function productPrices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function productSubstitutions(): HasMany
    {
        return $this->hasMany(ProductSubstitution::class);
    }

    public function productWarehouseStatus(): BelongsTo
    {
        return $this->belongsTo(ProductWarehouseStatus::class);
    }

    public function getCleanPriceAttribute()
    {
        if (auth()->check()) {
            return $this->productPrices()->first()->price / 100.0;
        } else {
            return 'Нет цены';
        }
    }

    public function hasStock(): bool
    {
        return $this
            ->warehouseProducts()
            ->where('quantity', '>', 0)
            ->exists();
    }

    /**
     * Какие поля индексировать
     */
    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'oem' => $this->oem ?? '',
            'search_text' => $this->search_text ?? '',
            'manufacturer_id' => (int) $this->manufacturer_id,
            'manufacturer_name' => $this->manufacturer->name ?? '',
            'on_sale' => (int) $this->on_sale,
            'in_stock' => (int) $this->hasStock(),
            'created_at' => (int) $this->created_at->timestamp,
        ];
    }

    /**
     * Название индекса в Meilisearch
     */
    public function searchableAs()
    {
        return 'products';
    }
}

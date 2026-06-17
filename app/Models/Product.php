<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'brand', 'cover', 'images',
        'short_desc', 'description', 'price', 'sale_price', 'stock',
        'attributes', 'featured', 'sira', 'durum',
    ];

    protected $casts = [
        'images'     => 'array',
        'attributes' => 'array',
        'featured'   => 'boolean',
        'durum'      => 'boolean',
        'price'      => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($q)
    {
        return $q->where('durum', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Geçerli satış fiyatı (indirim varsa indirimli) */
    public function getCurrentPriceAttribute(): float
    {
        return (float) ($this->sale_price ?: $this->price);
    }

    public function getOnSaleAttribute(): bool
    {
        return $this->sale_price !== null && (float) $this->sale_price > 0 && (float) $this->sale_price < (float) $this->price;
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->cover ?: 'https://placehold.co/600x600?text=Limon+Optik';
    }
}

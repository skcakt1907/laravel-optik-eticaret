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

    /**
     * Aktif ürünlerdeki markalar + ürün sayıları.
     *
     * $categoryId verilirse sadece o kategorideki markalar döner — mağazada
     * "Güneş Gözlüğü" seçiliyken yalnızca güneş gözlüğü markalarının
     * listelenmesi için. Boş/null markalar elenir.
     *
     * @return \Illuminate\Support\Collection<int, object{brand:string, adet:int}>
     */
    public static function markaListesi(?int $categoryId = null)
    {
        return static::query()
            ->active()
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->selectRaw('brand, COUNT(*) as adet')
            ->groupBy('brand')
            ->orderBy('brand')
            ->get();
    }

    /**
     * Aktif ürünlerdeki cinsiyet değerleri + ürün sayıları.
     *
     * Cinsiyet ayrı bir kategori değil, attributes json'unda bir alan
     * (bir çerçeve hem "Numaralı Gözlük" hem "Unisex" olabilsin diye).
     *
     * @return \Illuminate\Support\Collection<int, object{cinsiyet:string, adet:int}>
     */
    public static function cinsiyetListesi(?int $categoryId = null)
    {
        $alan = "JSON_UNQUOTE(JSON_EXTRACT(attributes, '$.cinsiyet'))";

        return static::query()
            ->active()
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->whereRaw("$alan IS NOT NULL")
            ->whereRaw("$alan != ''")
            ->selectRaw("$alan as cinsiyet, COUNT(*) as adet")
            ->groupBy('cinsiyet')
            ->orderByRaw("FIELD(cinsiyet, 'Unisex', 'Kadın', 'Erkek', 'Çocuk'), cinsiyet")
            ->get();
    }
}

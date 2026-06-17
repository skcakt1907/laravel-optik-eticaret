<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Yalnızca müşteri formundan gelen alanlar mass-assign edilebilir.
    // order_no, user_id, subtotal, shipping, total, payment_status, status, payment_meta
    // sunucu tarafında forceFill ile atanır (fiyat/yetki manipülasyonu önlemi).
    protected $fillable = ['name', 'email', 'phone', 'city', 'district', 'address', 'note'];

    protected $casts = [
        'payment_meta' => 'array',
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function statusLabels(): array
    {
        return [
            'yeni'         => 'Yeni',
            'hazirlaniyor' => 'Hazırlanıyor',
            'kargoda'      => 'Kargoda',
            'teslim'       => 'Teslim Edildi',
            'iptal'        => 'İptal',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }
}

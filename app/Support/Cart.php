<?php

namespace App\Support;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;

class Cart
{
    protected const KEY = 'cart';

    /** @return array<int,array{id:int,name:string,price:float,qty:int,image:string,slug:string}> */
    public static function items(): array
    {
        return Session::get(self::KEY, []);
    }

    public static function add(Product $product, int $qty = 1): void
    {
        $items = self::items();
        $id = $product->id;

        $current = $items[$id]['qty'] ?? 0;
        $qty = max(1, $current + $qty);
        $qty = min($qty, max(1, $product->stock)); // stok sınırı

        $items[$id] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'slug'  => $product->slug,
            'price' => $product->current_price,
            'qty'   => $qty,
            'image' => $product->image_url,
            'sku'   => $product->sku,
        ];

        Session::put(self::KEY, $items);
    }

    public static function update(int $id, int $qty): void
    {
        $items = self::items();
        if (! isset($items[$id])) {
            return;
        }
        if ($qty <= 0) {
            unset($items[$id]);
        } else {
            $product = Product::find($id);
            if ($product) {
                $qty = min($qty, max(1, $product->stock));
            }
            $items[$id]['qty'] = $qty;
        }
        Session::put(self::KEY, $items);
    }

    public static function remove(int $id): void
    {
        $items = self::items();
        unset($items[$id]);
        Session::put(self::KEY, $items);
    }

    public static function clear(): void
    {
        Session::forget(self::KEY);
    }

    public static function count(): int
    {
        return array_sum(array_column(self::items(), 'qty'));
    }

    public static function subtotal(): float
    {
        $sum = 0;
        foreach (self::items() as $it) {
            $sum += $it['price'] * $it['qty'];
        }
        return (float) $sum;
    }

    public static function shipping(): float
    {
        $sub = self::subtotal();
        if ($sub <= 0) {
            return 0;
        }
        $limit = (float) Setting::get('kargo_bedava_limit', 0);
        if ($limit > 0 && $sub >= $limit) {
            return 0;
        }
        return (float) Setting::get('kargo_ucreti', 0);
    }

    public static function total(): float
    {
        return self::subtotal() + self::shipping();
    }

    public static function isEmpty(): bool
    {
        return self::count() === 0;
    }
}

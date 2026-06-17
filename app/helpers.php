<?php

use App\Models\Setting;
use App\Support\Cart;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('money')) {
    function money($amount): string
    {
        return number_format((float) $amount, 2, ',', '.') . ' ₺';
    }
}

if (! function_exists('cart')) {
    function cart(): string
    {
        return Cart::class;
    }
}

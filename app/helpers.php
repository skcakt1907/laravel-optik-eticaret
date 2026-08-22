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

if (! function_exists('tel_link')) {
    /**
     * Ekranda gösterilen telefonu tel: bağlantısına uygun hale getirir.
     *
     * "0533 570 54 63" gibi boşluklu bir değer tel: içinde bazı cihazlarda
     * çevrilemiyor. Rakam dışındaki her şey atılır, baştaki 0 ülke koduna
     * çevrilir: tel:+905335705463
     * Numara zaten +90/90 ile başlıyorsa olduğu gibi korunur.
     */
    function tel_link(?string $telefon): string
    {
        $rakam = preg_replace('/\D/', '', (string) $telefon);

        if ($rakam === '') {
            return '';
        }

        if (str_starts_with($rakam, '90')) {
            return '+' . $rakam;
        }

        return '+90' . ltrim($rakam, '0');
    }
}

if (! function_exists('cart')) {
    function cart(): string
    {
        return Cart::class;
    }
}

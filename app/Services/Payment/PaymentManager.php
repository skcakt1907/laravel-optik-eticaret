<?php

namespace App\Services\Payment;

use InvalidArgumentException;

class PaymentManager
{
    public function driver(string $name): PaymentDriver
    {
        return match ($name) {
            'iyzico'           => new IyzicoDriver(),
            'havale', 'kapida' => new OfflineDriver(),
            default            => throw new InvalidArgumentException("Bilinmeyen ödeme sürücüsü: {$name}"),
        };
    }
}

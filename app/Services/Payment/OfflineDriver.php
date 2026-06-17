<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

/** Havale/EFT ve kapıda ödeme: çevrimdışı, anlık ödeme doğrulaması yok. */
class OfflineDriver implements PaymentDriver
{
    public function start(Order $order)
    {
        return null;
    }

    public function callback(Request $request, Order $order): bool
    {
        return false;
    }
}

<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

interface PaymentDriver
{
    /**
     * Ödemeyi başlat. Sanal POS sürücülerinde ödeme sayfasına yönlendirir
     * (RedirectResponse / View döner). Havale/kapıda gibi sürücülerde null.
     */
    public function start(Order $order);

    /**
     * Sanal POS dönüş (callback) doğrulaması. Başarılıysa true döner ve
     * siparişi 'paid' işaretler.
     */
    public function callback(Request $request, Order $order): bool;
}

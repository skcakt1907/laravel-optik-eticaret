<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Address;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;

class IyzicoDriver implements PaymentDriver
{
    protected function options(): Options
    {
        $options = new Options();
        $options->setApiKey(setting('iyzico_api_key', env('IYZICO_API_KEY')));
        $options->setSecretKey(setting('iyzico_secret', env('IYZICO_SECRET')));
        $sandbox = setting('iyzico_sandbox', '1') == '1';
        $options->setBaseUrl($sandbox ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com');

        return $options;
    }

    public function start(Order $order)
    {
        $request = new CreateCheckoutFormInitializeRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId((string) $order->id);
        $request->setPrice($this->fmt($order->subtotal));
        $request->setPaidPrice($this->fmt($order->total));
        $request->setCurrency(Currency::TL);
        $request->setBasketId($order->order_no);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('checkout.callback', $order->order_no));

        // Alıcı
        [$first, $last] = $this->splitName($order->name);
        $buyer = new Buyer();
        $buyer->setId((string) ($order->user_id ?: 'guest-' . $order->id));
        $buyer->setName($first);
        $buyer->setSurname($last);
        $buyer->setEmail($order->email);
        $buyer->setGsmNumber($order->phone);
        $buyer->setIdentityNumber('11111111111');
        $buyer->setRegistrationAddress($order->address);
        $buyer->setCity($order->city ?: 'Istanbul');
        $buyer->setCountry('Turkey');
        $buyer->setIp(request()->ip() ?: '127.0.0.1');
        $request->setBuyer($buyer);

        $address = new Address();
        $address->setContactName($order->name);
        $address->setCity($order->city ?: 'Istanbul');
        $address->setCountry('Turkey');
        $address->setAddress($order->address);
        $request->setShippingAddress($address);
        $request->setBillingAddress($address);

        // Sepet kalemleri (kargo dahil toplam, price ile eşleşmeli)
        $items = [];
        foreach ($order->items as $line) {
            $bi = new BasketItem();
            $bi->setId('P' . ($line->product_id ?: $line->id));
            $bi->setName($line->name);
            $bi->setCategory1($order->items->count() ? 'Optik' : 'Genel');
            $bi->setItemType(BasketItemType::PHYSICAL);
            $bi->setPrice($this->fmt($line->total));
            $items[] = $bi;
        }
        $request->setBasketItems($items);

        $init = CheckoutFormInitialize::create($request, $this->options());

        if ($init->getStatus() !== 'success') {
            Log::error('iyzico init failed', ['order' => $order->order_no, 'msg' => $init->getErrorMessage()]);
            return redirect()->route('checkout')->with('error', 'Ödeme başlatılamadı: ' . $init->getErrorMessage());
        }

        $order->forceFill(['payment_meta' => ['token' => $init->getToken()]])->save();

        return view('checkout.iyzico', [
            'order'   => $order,
            'content' => $init->getCheckoutFormContent(),
        ]);
    }

    public function callback(Request $request, Order $order): bool
    {
        $token = $request->input('token') ?? ($order->payment_meta['token'] ?? null);
        if (! $token) {
            return false;
        }

        $retrieve = new RetrieveCheckoutFormRequest();
        $retrieve->setToken($token);
        $result = CheckoutForm::retrieve($retrieve, $this->options());

        $paid = $result->getStatus() === 'success' && $result->getPaymentStatus() === 'SUCCESS';

        if ($paid) {
            $order->forceFill([
                'payment_status' => 'paid',
                'status'         => 'hazirlaniyor',
                'payment_meta'   => array_merge($order->payment_meta ?? [], [
                    'paymentId' => $result->getPaymentId(),
                    'token'     => $token,
                ]),
            ])->save();
        } else {
            $order->forceFill(['payment_status' => 'failed'])->save();
        }

        return $paid;
    }

    protected function fmt($amount): string
    {
        return number_format((float) $amount, 2, '.', '');
    }

    protected function splitName(string $name): array
    {
        $parts = preg_split('/\s+/', trim($name));
        if (count($parts) === 1) {
            return [$parts[0], '-'];
        }
        $last = array_pop($parts);
        return [implode(' ', $parts), $last];
    }
}

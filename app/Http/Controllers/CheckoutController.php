<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdmin;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Services\Payment\PaymentManager;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::isEmpty()) {
            return redirect()->route('cart')->with('error', 'Sepetiniz boş.');
        }

        return view('checkout.index', [
            'items'    => Cart::items(),
            'subtotal' => Cart::subtotal(),
            'shipping' => Cart::shipping(),
            'total'    => Cart::total(),
        ]);
    }

    public function store(Request $request)
    {
        if (Cart::isEmpty()) {
            return redirect()->route('cart')->with('error', 'Sepetiniz boş.');
        }

        $methods = ['havale'];
        if (setting('iyzico_aktif') == '1') {
            $methods[] = 'iyzico';
        }
        if (setting('kapida_aktif') == '1') {
            $methods[] = 'kapida';
        }

        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'required|email|max:120',
            'phone'   => 'required|string|max:30',
            'city'    => 'required|string|max:80',
            'district'=> 'nullable|string|max:80',
            'address' => 'required|string|max:1000',
            'note'    => 'nullable|string|max:1000',
            'payment_method' => 'required|in:' . implode(',', $methods),
            'sozlesme' => 'accepted',
        ], [
            'sozlesme.accepted' => 'Mesafeli satış sözleşmesini ve ön bilgilendirme formunu onaylamanız gerekir.',
        ]);

        try {
            $order = DB::transaction(function () use ($data) {
                // Müşteri alanları fillable; tutar/durum/sahiplik sunucu tarafında forceFill ile.
                $order = new Order([
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'phone'    => $data['phone'],
                    'city'     => $data['city'],
                    'district' => $data['district'] ?? null,
                    'address'  => $data['address'],
                    'note'     => $data['note'] ?? null,
                ]);
                $order->forceFill([
                    'order_no'       => $this->generateOrderNo(),
                    'user_id'        => auth()->id(),
                    'subtotal'       => Cart::subtotal(),
                    'shipping'       => Cart::shipping(),
                    'total'          => Cart::total(),
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'pending',
                    'status'         => 'yeni',
                ])->save();

                foreach (Cart::items() as $it) {
                    // Stok kilidi: aynı anda gelen siparişlerde aşırı satışı önler
                    $product = Product::where('id', $it['id'])->lockForUpdate()->first();

                    if (! $product || $product->stock < $it['qty']) {
                        throw new RuntimeException('"' . $it['name'] . '" için yeterli stok yok. Lütfen sepetinizi güncelleyin.');
                    }

                    $order->items()->create([
                        'product_id' => $it['id'],
                        'name'       => $it['name'],
                        'sku'        => $it['sku'] ?? null,
                        'price'      => $it['price'],
                        'qty'        => $it['qty'],
                        'total'      => $it['price'] * $it['qty'],
                    ]);

                    $product->decrement('stock', $it['qty']);
                }

                return $order;
            });
        } catch (RuntimeException $e) {
            return redirect()->route('cart')->with('error', $e->getMessage());
        }

        // Online ödeme ise sanal POS'a yönlendir
        if ($order->payment_method === 'iyzico') {
            return app(PaymentManager::class)->driver('iyzico')->start($order);
        }

        // Havale / Kapıda ödeme: sipariş alındı
        $this->sendOrderMails($order);
        Cart::clear();

        return redirect()->route('checkout.success', $order->order_no);
    }

    /** Sipariş onay maili (müşteri) + yeni sipariş bildirimi (admin) */
    protected function sendOrderMails(Order $order): void
    {
        try {
            $order->loadMissing('items');
            Mail::to($order->email)->send(new OrderPlaced($order));

            if ($adminMail = setting('eposta')) {
                Mail::to($adminMail)->send(new NewOrderAdmin($order));
            }
        } catch (\Throwable $e) {
            Log::error('Sipariş maili gönderilemedi', ['order' => $order->order_no, 'err' => $e->getMessage()]);
        }
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }

    public function callback(Request $request, Order $order)
    {
        $result = app(PaymentManager::class)->driver($order->payment_method)->callback($request, $order);

        if ($result) {
            $this->sendOrderMails($order->fresh());
            Cart::clear();
            return redirect()->route('checkout.success', $order->order_no)->with('success', 'Ödemeniz başarıyla alındı.');
        }

        return redirect()->route('checkout.success', $order->order_no)->with('error', 'Ödeme tamamlanamadı. Lütfen tekrar deneyin veya farklı bir yöntem seçin.');
    }

    protected function generateOrderNo(): string
    {
        do {
            $no = 'VO' . now()->format('ymd') . strtoupper(Str::random(4));
        } while (Order::where('order_no', $no)->exists());

        return $no;
    }
}

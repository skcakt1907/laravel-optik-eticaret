@extends('layouts.app')
@section('title', 'Sipariş Alındı — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="order-success-icon">
                    @if($order->payment_status === 'paid')
                        <i class="bi bi-check-lg"></i>
                    @else
                        <i class="bi bi-bag-check"></i>
                    @endif
                </div>
                <h1>Siparişiniz Alındı!</h1>
                <p style="color:var(--gray);font-size:1.1rem">Sipariş numaranız: <strong style="color:var(--ink)">{{ $order->order_no }}</strong></p>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                {{-- Havale bilgileri --}}
                @if($order->payment_method === 'havale' && $order->payment_status !== 'paid')
                <div class="checkout-section">
                    <h4><i class="bi bi-bank me-2"></i> Havale / EFT Bilgileri</h4>
                    <p>Aşağıdaki hesaba <strong>{{ money($order->total) }}</strong> tutarını gönderdikten sonra açıklamaya <strong>{{ $order->order_no }}</strong> yazmayı unutmayın. Ödemeniz onaylanınca siparişiniz hazırlanır.</p>
                    <ul class="pd-attrs">
                        <li><span>Banka</span><span>{{ setting('havale_banka') }}</span></li>
                        <li><span>Hesap Adı</span><span>{{ setting('havale_hesap_adi') }}</span></li>
                        <li><span>IBAN</span><span>{{ setting('havale_iban') }}</span></li>
                        <li><span>Tutar</span><span>{{ money($order->total) }}</span></li>
                        <li><span>Açıklama</span><span>{{ $order->order_no }}</span></li>
                    </ul>
                </div>
                @elseif($order->payment_method === 'kapida')
                <div class="alert-soft mb-4"><i class="bi bi-cash-coin me-1"></i> Ödemeyi teslimat sırasında kapıda yapacaksınız. Siparişiniz hazırlanıyor.</div>
                @elseif($order->payment_status === 'paid')
                <div class="alert-soft mb-4"><i class="bi bi-check-circle me-1"></i> Ödemeniz başarıyla alındı. Siparişiniz hazırlanmaya başlandı.</div>
                @endif

                {{-- Sipariş özeti --}}
                <div class="checkout-section">
                    <h4><i class="bi bi-receipt me-2"></i> Sipariş Özeti</h4>
                    <table class="cart-table">
                        <tbody>
                        @foreach($order->items as $it)
                            <tr><td>{{ $it->name }} × {{ $it->qty }}</td><td class="text-end">{{ money($it->total) }}</td></tr>
                        @endforeach
                        <tr><td>Kargo</td><td class="text-end">{{ $order->shipping > 0 ? money($order->shipping) : 'Ücretsiz' }}</td></tr>
                        <tr><td><strong>Toplam</strong></td><td class="text-end"><strong>{{ money($order->total) }}</strong></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-orange">Alışverişe Devam</a>
                    @auth<a href="{{ route('account.orders') }}" class="btn btn-line ms-2">Siparişlerim</a>@endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

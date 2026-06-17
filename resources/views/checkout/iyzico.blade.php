@extends('layouts.app')
@section('title', 'Güvenli Ödeme — ' . setting('site_adi'))

@section('content')
<section style="padding-top:60px;min-height:60vh">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="checkout-section">
                    <h4><i class="bi bi-shield-lock me-2"></i> Güvenli Ödeme</h4>
                    <p>Sipariş No: <strong>{{ $order->order_no }}</strong> — Tutar: <strong>{{ money($order->total) }}</strong></p>
                    {{-- iyzico CheckoutForm içeriği --}}
                    <div id="iyzipay-checkout-form" class="responsive">{!! $content !!}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

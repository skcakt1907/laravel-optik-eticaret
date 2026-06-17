@extends('layouts.app')
@section('title', $order->order_no . ' — ' . setting('site_adi'))

@section('content')
<section class="page-head"><div class="container"><h1>Sipariş {{ $order->order_no }}</h1></div></section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">@include('account.nav')</div>
            <div class="col-lg-9">
                <div class="side-card mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div><small style="color:var(--gray)">Durum</small><br><span class="status-pill {{ $order->status }}">{{ $order->status_label }}</span></div>
                    <div><small style="color:var(--gray)">Ödeme</small><br><strong>{{ ucfirst($order->payment_method) }}</strong> ({{ $order->payment_status === 'paid' ? 'Ödendi' : 'Bekliyor' }})</div>
                    <div><small style="color:var(--gray)">Tarih</small><br>{{ $order->created_at->format('d.m.Y H:i') }}</div>
                </div>

                <div class="side-card mb-4">
                    <h4>Ürünler</h4>
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

                <div class="side-card">
                    <h4>Teslimat Bilgileri</h4>
                    <p style="margin:0">{{ $order->name }} — {{ $order->phone }}<br>{{ $order->address }}<br>{{ $order->district }} / {{ $order->city }}</p>
                    @if($order->note)<p class="mt-2" style="color:var(--gray)"><strong>Not:</strong> {{ $order->note }}</p>@endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

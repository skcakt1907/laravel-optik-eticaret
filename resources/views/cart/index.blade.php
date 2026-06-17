@extends('layouts.app')
@section('title', 'Sepetim — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>Sepetim</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active">Sepet</li>
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        @if(empty($items))
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <h3>Sepetiniz boş</h3>
                <p>Henüz sepetinize ürün eklemediniz.</p>
                <a href="{{ route('shop') }}" class="btn btn-orange">Alışverişe Başla</a>
            </div>
        @else
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="side-card" style="padding:1rem 1.5rem">
                        <table class="cart-table">
                            <thead><tr><th>Ürün</th><th>Fiyat</th><th>Adet</th><th>Toplam</th><th></th></tr></thead>
                            <tbody>
                            @foreach($items as $it)
                                <tr>
                                    <td>
                                        <div class="cart-prod">
                                            <img src="{{ $it['image'] }}" alt="">
                                            <div>
                                                <strong><a href="{{ route('product', $it['slug']) }}" style="color:var(--ink)">{{ $it['name'] }}</a></strong>
                                                <small>{{ $it['sku'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ money($it['price']) }}</td>
                                    <td>
                                        <div class="qty-box">
                                            <button type="button" class="qminus">−</button>
                                            <input type="number" name="qty[{{ $it['id'] }}]" value="{{ $it['qty'] }}" min="1" onchange="this.form.submit()">
                                            <button type="button" class="qplus">+</button>
                                        </div>
                                    </td>
                                    <td><strong>{{ money($it['price'] * $it['qty']) }}</strong></td>
                                    <td>
                                        <button type="submit" formaction="{{ route('cart.remove', $it['id']) }}" class="cart-remove" title="Kaldır"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('shop') }}" class="btn btn-line"><i class="bi bi-arrow-left me-2"></i> Alışverişe Devam</a>
                        <button type="submit" class="btn btn-line"><i class="bi bi-arrow-repeat me-2"></i> Sepeti Güncelle</button>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4>Sipariş Özeti</h4>
                        <div class="summary-row"><span>Ara Toplam</span><span>{{ money($subtotal) }}</span></div>
                        <div class="summary-row"><span>Kargo</span><span>{{ $shipping > 0 ? money($shipping) : 'Ücretsiz' }}</span></div>
                        <div class="summary-row total"><span>Toplam</span><span>{{ money($total) }}</span></div>
                        <a href="{{ route('checkout') }}" class="btn btn-orange">Ödemeye Geç <i class="bi bi-arrow-right ms-2"></i></a>
                        @php $limit = (float) setting('kargo_bedava_limit'); @endphp
                        @if($limit > 0 && $subtotal < $limit)
                            <div class="free-ship-note"><i class="bi bi-truck me-1"></i> {{ money($limit - $subtotal) }} daha ekleyin, kargo <strong>ücretsiz</strong> olsun!</div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</section>
@endsection

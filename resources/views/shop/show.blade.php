@extends('layouts.app')
@section('title', $product->name . ' — ' . setting('site_adi'))
@section('meta', $product->short_desc)

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">Mağaza</a></li>
            @if($product->category)<li class="breadcrumb-item"><a href="{{ route('shop', ['kategori' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>@endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="pd-gallery">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="pd-brand">{{ $product->brand ?: $product->category?->name }}</div>
                <h1 class="pd-title">{{ $product->name }}</h1>

                <div class="pd-price">
                    <span class="now">{{ money($product->current_price) }}</span>
                    @if($product->on_sale)
                        <span class="old">{{ money($product->price) }}</span>
                        <span class="save">%{{ round((1 - $product->current_price / $product->price) * 100) }} indirim</span>
                    @endif
                </div>

                @if($product->in_stock)
                    <div class="pd-stock in"><i class="bi bi-check-circle-fill"></i> Stokta var ({{ $product->stock }} adet)</div>
                @else
                    <div class="pd-stock out"><i class="bi bi-x-circle-fill"></i> Stokta yok</div>
                @endif

                <p>{{ $product->short_desc }}</p>

                @if($product->attributes)
                <ul class="pd-attrs">
                    @foreach($product->attributes as $key => $val)
                        <li><span>{{ ucfirst(str_replace('_',' ',$key)) }}</span><span>{{ $val }}</span></li>
                    @endforeach
                </ul>
                @endif

                @if($product->in_stock)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="pd-actions">
                    @csrf
                    <div class="qty-box">
                        <button type="button" class="qminus">−</button>
                        <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}">
                        <button type="button" class="qplus">+</button>
                    </div>
                    <button type="submit" class="btn btn-orange"><i class="bi bi-bag-plus me-2"></i> Sepete Ekle</button>
                </form>
                @else
                    <a href="{{ route('contact') }}" class="btn btn-line">Stok için bilgi al</a>
                @endif

                <div class="alert-soft mt-4">
                    <i class="bi bi-info-circle me-1"></i> Numaralı cam siparişlerinde, ödeme sonrası reçete bilgileriniz için sizinle iletişime geçilir. Ücretsiz numara ölçümü mağazamızda yapılır.
                </div>
            </div>
        </div>

        {{-- Açıklama --}}
        <div class="row mt-5">
            <div class="col-lg-8">
                <h3 class="mb-3">Ürün Açıklaması</h3>
                <div style="color:var(--body)">{!! nl2br(e($product->description)) !!}</div>
            </div>
        </div>

        {{-- Benzer ürünler --}}
        @if($related->count())
        <div class="mt-5 pt-4">
            <div class="section-head"><span class="mini">Benzer Ürünler</span><h2>Bunları da <span>Beğenebilirsiniz</span></h2></div>
            <div class="row g-4">
                @foreach($related as $product)
                    <div class="col-lg-3 col-md-6">@include('partials.product-card')</div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

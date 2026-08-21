@extends('layouts.app')

@section('content')

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge"><i class="bi bi-circle-fill"></i> Net Görüş · Şık Tasarım · Uzman Optisyen</span>
                <h1>Gözlüğünü Seç,<br>Net Bir <span>Bakış</span> Yakala.</h1>
                <p>{{ setting('site_aciklama') }}</p>
                <div class="hero-cta">
                    <a href="{{ route('shop') }}" class="btn btn-orange">Alışverişe Başla <i class="bi bi-arrow-right ms-2"></i></a>
                    <a href="{{ route('contact') }}" class="btn btn-line">Ücretsiz Göz Tahlili</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-visual">
                    <img src="https://images.unsplash.com/photo-1577744486770-020ab432da65?w=900&q=85" alt="{{ setting('site_adi') }}">
                    <div class="hero-float">
                        <i class="bi bi-truck"></i>
                        <div><strong>Hızlı Kargo</strong><small>{{ money(setting('kargo_bedava_limit')) }} üzeri ücretsiz</small></div>
                    </div>
                    <div class="hero-float top">
                        <i class="bi bi-patch-check"></i>
                        <div><strong>Orijinal Ürün</strong><small>Garantili & faturalı</small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-meta">
            <div class="row g-3">
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-truck"></i><div><strong>Ücretsiz Kargo</strong><small>{{ money(setting('kargo_bedava_limit')) }} üzeri</small></div></div></div>
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-arrow-repeat"></i><div><strong>Kolay İade</strong><small>14 gün içinde</small></div></div></div>
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-shield-check"></i><div><strong>Güvenli Ödeme</strong><small>3D Secure</small></div></div></div>
                <div class="col-md-3 col-6"><div class="meta-item"><i class="bi bi-eye"></i><div><strong>Ücretsiz Tahlil</strong><small>Mağazamızda</small></div></div></div>
            </div>
        </div>
    </div>
</section>

{{-- Kategoriler --}}
<section class="services-grid">
    <div class="container">
        <div class="section-head center">
            <span class="mini">Kategoriler</span>
            <h2>Ne <span>Arıyorsunuz?</span></h2>
        </div>
        <div class="row g-4">
            @foreach($categories as $cat)
            <div class="col-lg col-md-4 col-6">
                <a href="{{ route('shop', ['kategori' => $cat->slug]) }}" class="service-card text-center" style="align-items:center">
                    <div class="icon mx-auto"><i class="bi {{ $cat->icon ?: 'bi-eyeglasses' }}"></i></div>
                    <h4 style="font-size:1.05rem">{{ $cat->name }}</h4>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Kayan marka şeridi --}}
@if($brands->count())
<section class="brand-marquee-wrap">
    <div class="container">
        <div class="section-head center">
            <span class="mini">Markalar</span>
            <h2>Çalıştığımız <span>Markalar</span></h2>
        </div>
    </div>
    {{-- Şerit kesintisiz aksın diye liste iki kez basılıyor: ilk kopya
         ekranın dışına çıkarken ikincisi içeri girer. aria-hidden ile
         ekran okuyucuya aynı markalar iki kez okutulmuyor. --}}
    <div class="brand-marquee" role="list">
        <div class="brand-marquee-track">
            @foreach($brands as $b)
                <a href="{{ route('shop', ['marka' => $b->brand]) }}" class="brand-chip" role="listitem">{{ $b->brand }}</a>
            @endforeach
            @foreach($brands as $b)
                <a href="{{ route('shop', ['marka' => $b->brand]) }}" class="brand-chip" aria-hidden="true" tabindex="-1">{{ $b->brand }}</a>
            @endforeach
        </div>
    </div>
    <div class="container text-center" style="margin-top:26px">
        <a href="{{ route('brands') }}" class="btn-line">Tüm Markalar</a>
    </div>
</section>
@endif

{{-- Öne çıkan ürünler --}}
@if($featured->count())
<section>
    <div class="container">
        <div class="section-head d-flex justify-content-between align-items-end flex-wrap">
            <div>
                <span class="mini">Vitrin</span>
                <h2>Öne Çıkan <span>Ürünler</span></h2>
            </div>
            <a href="{{ route('shop') }}" class="btn btn-orange">Tümü <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        <div class="row g-4">
            @foreach($featured as $product)
                <div class="col-lg-3 col-md-6">@include('partials.product-card')</div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="cta-strip">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8"><h3>Ücretsiz göz tahliliniz için randevu alın</h3><p>Uzman optisyenlerimiz numaranızı ölçsün, size en uygun cam ve çerçeveyi birlikte seçelim.</p></div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0"><a href="{{ route('contact') }}" class="btn">Randevu Al <i class="bi bi-arrow-right ms-2"></i></a></div>
        </div>
    </div>
</section>

{{-- Yeni ürünler --}}
@if($newProducts->count())
<section style="padding-top:30px">
    <div class="container">
        <div class="section-head center">
            <span class="mini">Yeni Gelenler</span>
            <h2>En Yeni <span>Modeller</span></h2>
        </div>
        <div class="row g-4">
            @foreach($newProducts as $product)
                <div class="col-lg-3 col-md-6">@include('partials.product-card')</div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Hizmetler --}}
<section class="services-grid">
    <div class="container">
        <div class="section-head center">
            <span class="mini">Hizmetlerimiz</span>
            <h2>Sunduğumuz <span>Optik Hizmetler</span></h2>
        </div>
        <div class="row g-4">
            @foreach($services as $h)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('service.show', $h) }}" class="service-card">
                    <div class="icon"><i class="bi {{ $h->icon }}"></i></div>
                    <h4>{{ $h->title }}</h4>
                    <p>{{ $h->summary }}</p>
                    <span class="more">Detay <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Yorumlar --}}
@if($testimonials->count())
<section>
    <div class="container">
        <div class="section-head center">
            <span class="mini">Referanslar</span>
            <h2>Müşterilerimiz <span>Ne Diyor?</span></h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $r)
            <div class="col-lg-4 col-md-6">
                <div class="testi">
                    <div class="stars">{{ str_repeat('★', (int) $r->stars) }}</div>
                    <p>"{{ $r->comment }}"</p>
                    <div class="testi-user">
                        <img src="{{ $r->photo ?: 'https://ui-avatars.com/api/?name='.urlencode($r->name).'&background=0d9488&color=fff' }}" alt="">
                        <div><h6>{{ $r->name }}</h6><span>{{ $r->title }}</span></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Blog --}}
@if($posts->count())
<section class="services-grid">
    <div class="container">
        <div class="section-head center">
            <span class="mini">Blog</span>
            <h2>Göz Sağlığı & <span>Stil Rehberi</span></h2>
        </div>
        <div class="row g-4">
            @foreach($posts as $b)
            <div class="col-lg-4 col-md-6">
                <div class="blog-card">
                    <div class="img">
                        <img src="{{ $b->image }}" alt="">
                        <span class="cat">{{ $b->category }}</span>
                    </div>
                    <div class="blog-body">
                        <div class="meta"><i class="bi bi-calendar3"></i>{{ optional($b->tarih)->format('d.m.Y') }}</div>
                        <h5><a href="{{ route('blog.show', $b) }}">{{ $b->title }}</a></h5>
                        <p>{{ $b->summary }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

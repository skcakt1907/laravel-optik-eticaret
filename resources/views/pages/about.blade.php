@extends('layouts.app')
@section('title', 'Hakkımızda — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>Hakkımızda</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active">Hakkımızda</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="about-img-wrap">
                    <img src="https://images.unsplash.com/photo-1556015048-4d3aa10df74c?w=900&q=85" alt="">
                    <div class="exp-badge"><span class="num">{{ setting('yil') }}+</span><span class="lbl">Yıllık Tecrübe</span></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-head">
                    <span class="mini">Hakkımızda</span>
                    <h2>Net Görüş,<br><span>Şık Tasarım</span></h2>
                    <p class="desc">{{ setting('site_aciklama') }}</p>
                </div>
                <ul class="about-features">
                    <li><i class="bi bi-check"></i> Ücretsiz Bilgisayarlı Göz Tahlili</li>
                    <li><i class="bi bi-check"></i> Uzman Optisyen Danışmanlığı</li>
                    <li><i class="bi bi-check"></i> Dünya Markası Çerçeve & Cam</li>
                    <li><i class="bi bi-check"></i> Anti-reflit & Mavi Işık Filtreli Cam</li>
                </ul>
                <a href="{{ route('shop') }}" class="btn btn-orange mt-4">Ürünleri İncele <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<section class="services-grid">
    <div class="container">
        <div class="section-head center"><span class="mini">Hizmetlerimiz</span><h2>Sunduğumuz <span>Hizmetler</span></h2></div>
        <div class="row g-4">
            @foreach($services as $h)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('service.show', $h) }}" class="service-card">
                    <div class="icon"><i class="bi {{ $h->icon }}"></i></div>
                    <h4>{{ $h->title }}</h4>
                    <p>{{ $h->summary }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

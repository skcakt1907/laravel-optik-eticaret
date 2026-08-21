@extends('layouts.app')
@section('title', 'Markalar — ' . setting('site_adi'))
@section('meta', setting('site_adi') . ' bünyesinde satılan gözlük ve lens markaları.')

@section('content')
<section class="page-head">
    <div class="container">
        <h1>Markalar</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active">Markalar</li>
        </ol></nav>
    </div>
</section>

<section style="padding:60px 0">
    <div class="container">
        @if($brands->count())
            <div class="section-head center">
                <h2>Çalıştığımız Markalar</h2>
                <p>Marka adına tıklayarak o markanın tüm ürünlerini görüntüleyebilirsiniz.</p>
            </div>

            <div class="row g-4">
                @foreach($brands as $b)
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="{{ route('shop', ['marka' => $b->brand]) }}" class="brand-card">
                            <span class="brand-card-name">{{ $b->brand }}</span>
                            <span class="brand-card-count">{{ $b->adet }} ürün</span>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-tags"></i>
                <h3>Henüz marka eklenmemiş</h3>
                <p>Ürünlere marka bilgisi girildiğinde bu sayfada listelenecektir.</p>
                <a href="{{ route('shop') }}" class="btn btn-orange">Mağazaya Git</a>
            </div>
        @endif
    </div>
</section>
@endsection

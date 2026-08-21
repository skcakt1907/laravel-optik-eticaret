@extends('layouts.app')
@section('title', trim(implode(' ', array_filter([$activeBrand ?? null, $activeGender ?? null, $activeCat->name ?? 'Mağaza']))) . ' — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        @php
            // Başlık seçili filtreleri yansıtsın: "Ray-Ban Güneş Gözlüğü",
            // "Unisex Numaralı Gözlük" gibi okunur bir başlık üretir.
            $baslikParcalari = array_filter([$activeBrand, $activeGender, $activeCat?->name]);
            $sayfaBaslik = $baslikParcalari ? implode(' ', $baslikParcalari) : 'Tüm Ürünler';
        @endphp
        <h1>{{ $sayfaBaslik }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">Mağaza</a></li>
            @if($activeCat)
                <li class="breadcrumb-item {{ $activeBrand || $activeGender ? '' : 'active' }}">
                    @if($activeBrand || $activeGender)
                        <a href="{{ route('shop', ['kategori' => $activeCat->slug]) }}">{{ $activeCat->name }}</a>
                    @else
                        {{ $activeCat->name }}
                    @endif
                </li>
            @endif
            @if($activeBrand)<li class="breadcrumb-item active">{{ $activeBrand }}</li>@endif
            @if($activeGender && !$activeBrand)<li class="breadcrumb-item active">{{ $activeGender }}</li>@endif
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        <div class="row g-4">
            {{-- Yan filtre --}}
            <div class="col-lg-3">
                <div class="shop-filter">
                    <h5>Kategoriler</h5>
                    <ul class="f-list">
                        <li><a href="{{ route('shop') }}" class="{{ !$activeCat ? 'active' : '' }}">Tümü</a></li>
                        @foreach($categories as $cat)
                            <li><a href="{{ route('shop', ['kategori' => $cat->slug]) }}" class="{{ $activeCat?->id === $cat->id ? 'active' : '' }}">
                                {{ $cat->name }} <span>{{ $cat->products_count }}</span>
                            </a></li>
                        @endforeach
                    </ul>

                    {{-- Cinsiyet (Unisex dahil). Kategori değil, ürün özelliği. --}}
                    @if($genders->count())
                        <h5>Cinsiyet</h5>
                        <ul class="f-list">
                            <li><a href="{{ route('shop', array_merge(request()->except(['cinsiyet','page']), [])) }}"
                                   class="{{ !$activeGender ? 'active' : '' }}">Tümü</a></li>
                            @foreach($genders as $g)
                                <li><a href="{{ route('shop', array_merge(request()->except('page'), ['cinsiyet' => $g->cinsiyet])) }}"
                                       class="{{ $activeGender === $g->cinsiyet ? 'active' : '' }}">
                                    {{ $g->cinsiyet }} <span>{{ $g->adet }}</span>
                                </a></li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Markalar. Kategori seçiliyse sadece o kategorinin markaları
                         listelenir (ör. Güneş Gözlüğü içinde marka marka ayrım). --}}
                    @if($brands->count())
                        <h5>{{ $activeCat ? $activeCat->name . ' Markaları' : 'Markalar' }}</h5>
                        <ul class="f-list">
                            <li><a href="{{ route('shop', array_merge(request()->except(['marka','page']), [])) }}"
                                   class="{{ !$activeBrand ? 'active' : '' }}">Tümü</a></li>
                            @foreach($brands as $b)
                                <li><a href="{{ route('shop', array_merge(request()->except('page'), ['marka' => $b->brand])) }}"
                                       class="{{ $activeBrand === $b->brand ? 'active' : '' }}">
                                    {{ $b->brand }} <span>{{ $b->adet }}</span>
                                </a></li>
                            @endforeach
                        </ul>
                    @endif

                    <h5>Arama</h5>
                    <form action="{{ route('shop') }}" method="GET">
                        {{-- Arama her zaman TÜM üründe arar (kategoriyle sınırlama yok) --}}
                        <div class="input-group">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Ürün ara..." style="border-radius:100px 0 0 100px;border:1px solid var(--line)">
                            <button class="btn btn-orange" style="border-radius:0 100px 100px 0"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Ürün listesi --}}
            <div class="col-lg-9">
                <div class="shop-toolbar">
                    <span class="count">{{ $products->total() }} ürün bulundu</span>
                    <form method="GET" id="sortForm">
                        @foreach(request()->except('sirala','page') as $k => $v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
                        <select name="sirala" onchange="document.getElementById('sortForm').submit()">
                            <option value="">Önerilen Sıralama</option>
                            <option value="yeni" @selected(request('sirala')=='yeni')>En Yeniler</option>
                            <option value="ucuz" @selected(request('sirala')=='ucuz')>Fiyat (Artan)</option>
                            <option value="pahali" @selected(request('sirala')=='pahali')>Fiyat (Azalan)</option>
                        </select>
                    </form>
                </div>

                @if($products->count())
                    <div class="row g-4">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">@include('partials.product-card')</div>
                        @endforeach
                    </div>
                    <div class="mt-5">{{ $products->links() }}</div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-search"></i>
                        <h3>Ürün bulunamadı</h3>
                        <p>Arama kriterlerinize uygun ürün yok.</p>
                        <a href="{{ route('shop') }}" class="btn btn-orange">Tüm Ürünler</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

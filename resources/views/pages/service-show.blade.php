@extends('layouts.app')
@section('title', $service->title . ' — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ $service->title }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services') }}">Hizmetler</a></li>
            <li class="breadcrumb-item active">{{ $service->title }}</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                @if($service->image)<img src="{{ $service->image }}" class="w-100 rounded mb-4" alt="">@endif
                <span class="badge-mini">{{ $service->title }}</span>
                <h2>{{ $service->title }}</h2>
                <p class="lead">{{ $service->summary }}</p>
                <div>{!! nl2br(e($service->content)) !!}</div>
            </div>
            <div class="col-lg-4">
                <div class="side-card mb-4">
                    <h4>Diğer Hizmetlerimiz</h4>
                    <div class="side-list">
                        @foreach($others as $o)
                            <a href="{{ route('service.show', $o) }}"><i class="bi {{ $o->icon }}"></i><span>{{ $o->title }}</span></a>
                        @endforeach
                    </div>
                </div>
                <div class="side-cta">
                    <h5>Randevu Almak İster misiniz?</h5>
                    <p>Ücretsiz göz tahlili için hemen randevu oluşturun.</p>
                    <a href="{{ route('contact') }}" class="btn">Randevu Al</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')
@section('title', $post->title . ' — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li>
            <li class="breadcrumb-item active">{{ $post->title }}</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                @if($post->image)<img src="{{ $post->image }}" class="w-100 rounded mb-4" alt="">@endif
                <div class="blog-meta mb-3"><i class="bi bi-calendar3"></i>{{ optional($post->tarih)->format('d.m.Y') }} <span class="ms-2"><i class="bi bi-tag"></i> {{ $post->category }}</span></div>
                <p class="lead">{{ $post->summary }}</p>
                <div>{!! nl2br(e($post->content)) !!}</div>
            </div>
            <div class="col-lg-4">
                <div class="side-card">
                    <h4>Diğer Yazılar</h4>
                    <div class="side-list media">
                        @foreach($others as $o)
                            <a href="{{ route('blog.show', $o) }}">
                                <img src="{{ $o->image }}" alt="">
                                <span><strong>{{ \Illuminate\Support\Str::limit($o->title, 40) }}</strong><small>{{ $o->category }}</small></span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

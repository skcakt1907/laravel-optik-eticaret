@extends('layouts.app')
@section('title', $pageTitle . ' — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>{{ $pageTitle }}</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
        </ol></nav>
    </div>
</section>

<section style="padding:50px 0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="legal-content" style="line-height:1.8;color:#374151">
                    @include($bodyView)
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

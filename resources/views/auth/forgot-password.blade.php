@extends('layouts.app')
@section('title', 'Şifremi Unuttum — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:linear-gradient(160deg,var(--soft) 0%,#fff 60%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">Şifremi Unuttum</h2>
                        <p style="color:var(--gray)">E-posta adresinizi girin, sıfırlama bağlantısı gönderelim.</p>
                    </div>
                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('password.email') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="mb-3"><label class="form-label">E-Posta</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                        <button type="submit" class="btn btn-orange w-100">Sıfırlama Bağlantısı Gönder</button>
                    </form>
                    <p class="text-center mt-3 mb-0" style="font-size:.92rem"><a href="{{ route('login') }}" style="color:var(--primary);font-weight:600">Girişe dön</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')
@section('title', 'Giriş Yap — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:linear-gradient(160deg,var(--soft) 0%,#fff 60%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">Tekrar Hoş Geldiniz</h2>
                        <p style="color:var(--gray)">Hesabınıza giriş yapın</p>
                    </div>
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('login') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="mb-3"><label class="form-label">E-Posta</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                        <div class="mb-3"><label class="form-label">Şifre</label><input type="password" name="password" class="form-control" required></div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check mb-0"><input type="checkbox" name="remember" class="form-check-input" id="rmb"><label class="form-check-label" for="rmb" style="font-size:.9rem">Beni hatırla</label></div>
                            <a href="{{ route('password.request') }}" style="font-size:.85rem;color:var(--gray)">Şifremi unuttum</a>
                        </div>
                        <button type="submit" class="btn btn-orange w-100">Giriş Yap</button>
                    </form>
                    <p class="text-center mt-3 mb-0" style="font-size:.92rem">Hesabınız yok mu? <a href="{{ route('register') }}" style="color:var(--primary);font-weight:600">Kayıt Olun</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

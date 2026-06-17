@extends('layouts.app')
@section('title', 'Kayıt Ol — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:linear-gradient(160deg,var(--soft) 0%,#fff 60%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">Hesap Oluştur</h2>
                        <p style="color:var(--gray)">Hızlı ve kolay üyelik</p>
                    </div>
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('register') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="mb-3"><label class="form-label">Ad Soyad</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                        <div class="mb-3"><label class="form-label">E-Posta</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                        <div class="mb-3"><label class="form-label">Telefon</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="mb-3"><label class="form-label">Şifre</label><input type="password" name="password" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Şifre (Tekrar)</label><input type="password" name="password_confirmation" class="form-control" required></div>
                        <button type="submit" class="btn btn-orange w-100">Kayıt Ol</button>
                    </form>
                    <p class="text-center mt-3 mb-0" style="font-size:.92rem">Zaten üye misiniz? <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600">Giriş Yapın</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

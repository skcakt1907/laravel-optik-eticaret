@extends('layouts.app')
@section('title', 'Şifre Sıfırla — ' . setting('site_adi'))

@section('content')
<section style="padding-top:70px;min-height:70vh;background:linear-gradient(160deg,var(--soft) 0%,#fff 60%)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="side-card" style="padding:2.5rem">
                    <div class="text-center mb-4">
                        <h2 style="font-size:1.6rem">Yeni Şifre Belirle</h2>
                        <p style="color:var(--gray)">Hesabınız için yeni bir şifre oluşturun.</p>
                    </div>
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <form action="{{ route('password.update') }}" method="POST" class="contact-form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3"><label class="form-label">E-Posta</label><input type="email" name="email" class="form-control" required value="{{ old('email', $email) }}"></div>
                        <div class="mb-3"><label class="form-label">Yeni Şifre</label><input type="password" name="password" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Yeni Şifre (Tekrar)</label><input type="password" name="password_confirmation" class="form-control" required></div>
                        <button type="submit" class="btn btn-orange w-100">Şifreyi Güncelle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

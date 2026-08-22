@extends('layouts.app')
@section('title', 'İletişim & Randevu — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>İletişim & Randevu</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item active">İletişim</li>
        </ol></nav>
    </div>
</section>

<section>
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-geo-alt"></i><h5>Adres</h5><p>{{ setting('adres') }}</p></div></div>
            <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-telephone"></i><h5>Telefon</h5><p><a href="tel:{{ tel_link(setting('telefon')) }}">{{ setting('telefon') }}</a></p></div></div>
            <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-envelope"></i><h5>E-Posta</h5><p><a href="mailto:{{ setting('eposta') }}">{{ setting('eposta') }}</a></p></div></div>
        </div>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="section-head"><span class="mini">Randevu</span><h2>Ücretsiz Göz Tahlili <span>Randevusu</span></h2></div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('appointment') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Ad Soyad *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                        <div class="col-md-6"><label class="form-label">Telefon *</label><input type="text" name="phone" class="form-control" required value="{{ old('phone') }}"></div>
                        <div class="col-md-6"><label class="form-label">E-Posta</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
                        <div class="col-md-3"><label class="form-label">Tarih</label><input type="date" name="date" class="form-control" value="{{ old('date') }}"></div>
                        <div class="col-md-3"><label class="form-label">Saat</label><input type="time" name="time" class="form-control" value="{{ old('time') }}"></div>
                        <div class="col-12"><label class="form-label">Not</label><textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea></div>
                        <div class="col-12"><button type="submit" class="btn btn-orange">Randevu Talebi Gönder <i class="bi bi-arrow-right ms-2"></i></button></div>
                    </div>
                </form>

                <div class="section-head mt-5"><span class="mini">İletişim</span><h2>Bize <span>Yazın</span></h2></div>
                <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Ad Soyad *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                        <div class="col-md-6"><label class="form-label">Telefon</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="col-md-6"><label class="form-label">E-Posta</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
                        <div class="col-md-6"><label class="form-label">Konu</label><input type="text" name="subject" class="form-control" value="{{ old('subject') }}"></div>
                        <div class="col-12"><label class="form-label">Mesajınız *</label><textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea></div>
                        <div class="col-12"><button type="submit" class="btn btn-line">Mesajı Gönder <i class="bi bi-send ms-2"></i></button></div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="quote-call">
                    <div class="quote-call-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div><small>Hemen Arayın</small><a href="tel:{{ tel_link(setting('telefon')) }}">{{ setting('telefon') }}</a></div>
                </div>
                <ul class="quote-perks">
                    <li><i class="bi bi-eye"></i><div><strong>Ücretsiz Göz Tahlili</strong><span>Bilgisayarlı hassas ölçüm</span></div></li>
                    <li><i class="bi bi-patch-check"></i><div><strong>Orijinal Ürün Garantisi</strong><span>Dünya markaları</span></div></li>
                    <li><i class="bi bi-clock-history"></i><div><strong>Aynı Gün Teslim</strong><span>Çoğu gözlükte</span></div></li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

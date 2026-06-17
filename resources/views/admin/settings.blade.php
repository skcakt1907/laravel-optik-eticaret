@extends('admin.layout')
@section('title', 'Ayarlar')

@section('content')
@php $s = fn($k, $d='') => old($k, $settings[$k] ?? $d); @endphp
<form action="{{ route('admin.settings.update') }}" method="POST" class="form-a">
    @csrf
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card-a">
                <h3 style="font-size:1rem;margin-top:0">Site Bilgileri</h3>
                <label>Site Adı</label><input name="site_adi" value="{{ $s('site_adi') }}">
                <label>Site Açıklaması</label><textarea name="site_aciklama" rows="3">{{ $s('site_aciklama') }}</textarea>
                <label>Tecrübe Yılı</label><input name="yil" value="{{ $s('yil') }}">
            </div>

            <div class="card-a mt-4">
                <h3 style="font-size:1rem;margin-top:0">İletişim</h3>
                <label>Telefon</label><input name="telefon" value="{{ $s('telefon') }}">
                <label>WhatsApp (905...)</label><input name="whatsapp" value="{{ $s('whatsapp') }}">
                <label>E-Posta</label><input name="eposta" value="{{ $s('eposta') }}">
                <label>Adres</label><textarea name="adres" rows="2">{{ $s('adres') }}</textarea>
                <label>Instagram</label><input name="instagram" value="{{ $s('instagram') }}">
                <label>Facebook</label><input name="facebook" value="{{ $s('facebook') }}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-a">
                <h3 style="font-size:1rem;margin-top:0">Kargo</h3>
                <label>Kargo Ücreti (₺)</label><input name="kargo_ucreti" value="{{ $s('kargo_ucreti') }}">
                <label>Ücretsiz Kargo Limiti (₺)</label><input name="kargo_bedava_limit" value="{{ $s('kargo_bedava_limit') }}">
            </div>

            <div class="card-a mt-4">
                <h3 style="font-size:1rem;margin-top:0">Havale / EFT</h3>
                <label>Banka</label><input name="havale_banka" value="{{ $s('havale_banka') }}">
                <label>Hesap Adı</label><input name="havale_hesap_adi" value="{{ $s('havale_hesap_adi') }}">
                <label>IBAN</label><input name="havale_iban" value="{{ $s('havale_iban') }}">
            </div>

            <div class="card-a mt-4">
                <h3 style="font-size:1rem;margin-top:0">Ödeme Yöntemleri</h3>
                <label><input type="hidden" name="kapida_aktif" value="0"><input type="checkbox" name="kapida_aktif" value="1" @checked($s('kapida_aktif')=='1') style="width:auto"> Kapıda Ödeme aktif</label>
                <label><input type="hidden" name="iyzico_aktif" value="0"><input type="checkbox" name="iyzico_aktif" value="1" @checked($s('iyzico_aktif')=='1') style="width:auto"> iyzico Sanal POS aktif</label>

                <label>iyzico API Key</label><input name="iyzico_api_key" value="{{ $s('iyzico_api_key') }}">
                <label>iyzico Secret Key</label><input name="iyzico_secret" value="{{ $s('iyzico_secret') }}">
                <label><input type="hidden" name="iyzico_sandbox" value="0"><input type="checkbox" name="iyzico_sandbox" value="1" @checked($s('iyzico_sandbox','1')=='1') style="width:auto"> Sandbox (test) modu</label>
            </div>
        </div>
    </div>

    <div class="mt-4"><button class="btn-a"><i class="bi bi-check-lg"></i> Tüm Ayarları Kaydet</button></div>
</form>
@endsection

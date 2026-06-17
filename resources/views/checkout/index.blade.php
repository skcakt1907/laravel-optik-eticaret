@extends('layouts.app')
@section('title', 'Ödeme — ' . setting('site_adi'))

@section('content')
<section class="page-head">
    <div class="container">
        <h1>Ödeme</h1>
        <nav><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Sepet</a></li>
            <li class="breadcrumb-item active">Ödeme</li>
        </ol></nav>
    </div>
</section>

<section style="padding-top:50px">
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="checkout-section">
                        <h4><span class="step">1</span> Teslimat Bilgileri</h4>
                        <div class="row g-3 contact-form">
                            @php $u = auth()->user(); @endphp
                            <div class="col-md-6"><label class="form-label">Ad Soyad *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $u->name ?? '') }}"></div>
                            <div class="col-md-6"><label class="form-label">Telefon *</label><input type="text" name="phone" class="form-control" required value="{{ old('phone', $u->phone ?? '') }}"></div>
                            <div class="col-md-6"><label class="form-label">E-Posta *</label><input type="email" name="email" class="form-control" required value="{{ old('email', $u->email ?? '') }}"></div>
                            <div class="col-md-3"><label class="form-label">İl *</label><input type="text" name="city" class="form-control" required value="{{ old('city') }}"></div>
                            <div class="col-md-3"><label class="form-label">İlçe</label><input type="text" name="district" class="form-control" value="{{ old('district') }}"></div>
                            <div class="col-12"><label class="form-label">Adres *</label><textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea></div>
                            <div class="col-12"><label class="form-label">Sipariş Notu</label><textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea></div>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h4><span class="step">2</span> Ödeme Yöntemi</h4>

                        <label class="pay-opt active">
                            <input type="radio" name="payment_method" value="havale" checked>
                            <i class="bi bi-bank ic"></i>
                            <div><strong>Havale / EFT</strong><small>Sipariş sonrası IBAN bilgileri gösterilir.</small></div>
                        </label>

                        @if(setting('iyzico_aktif') == '1')
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="iyzico">
                            <i class="bi bi-credit-card ic"></i>
                            <div><strong>Kredi / Banka Kartı</strong><small>3D Secure güvenli ödeme (iyzico).</small></div>
                        </label>
                        @endif

                        @if(setting('kapida_aktif') == '1')
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="kapida">
                            <i class="bi bi-cash-coin ic"></i>
                            <div><strong>Kapıda Ödeme</strong><small>Ürünü teslim alırken nakit/kart ile ödeyin.</small></div>
                        </label>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4>Sipariş Özeti</h4>
                        @foreach($items as $it)
                            <div class="summary-row"><span>{{ $it['name'] }} × {{ $it['qty'] }}</span><span>{{ money($it['price'] * $it['qty']) }}</span></div>
                        @endforeach
                        <hr style="border-color:var(--line)">
                        <div class="summary-row"><span>Ara Toplam</span><span>{{ money($subtotal) }}</span></div>
                        <div class="summary-row"><span>Kargo</span><span>{{ $shipping > 0 ? money($shipping) : 'Ücretsiz' }}</span></div>
                        <div class="summary-row total"><span>Toplam</span><span>{{ money($total) }}</span></div>
                        <div class="form-check my-3" style="font-size:.85rem">
                            <input type="checkbox" name="sozlesme" value="1" class="form-check-input" id="sozlesme" {{ old('sozlesme') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="sozlesme">
                                <a href="{{ route('legal', 'on-bilgilendirme') }}" target="_blank">Ön Bilgilendirme Formu</a> ve
                                <a href="{{ route('legal', 'mesafeli-satis-sozlesmesi') }}" target="_blank">Mesafeli Satış Sözleşmesi</a>'ni okudum, onaylıyorum.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-orange">Siparişi Tamamla <i class="bi bi-check2 ms-2"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.pay-opt input').forEach(r => r.addEventListener('change', () => {
    document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('active'));
    r.closest('.pay-opt').classList.add('active');
}));
</script>
@endpush
@endsection

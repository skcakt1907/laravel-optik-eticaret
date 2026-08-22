<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="brand">
                    <img src="{{ asset('img/logo.png') }}" alt="{{ setting('site_adi') }}">
                </div>
                <p>{{ setting('site_aciklama') }}</p>
                <div class="social">
                    <a href="{{ setting('instagram', '#') }}" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="{{ setting('facebook', '#') }}" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://wa.me/{{ setting('whatsapp') }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Mağaza</h5>
                @foreach($navCategories as $cat)
                    <a href="{{ route('shop', ['kategori' => $cat->slug]) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Kurumsal</h5>
                <a href="{{ route('about') }}">Hakkımızda</a>
                @if($navHasServices ?? false)<a href="{{ route('services') }}">Hizmetler</a>@endif
                <a href="{{ route('blog') }}">Blog</a>
                <a href="{{ route('contact') }}">İletişim</a>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5>İletişim</h5>
                <div class="contact-li"><i class="bi bi-geo-alt"></i><span>{{ setting('adres') }}</span></div>
                <div class="contact-li"><i class="bi bi-telephone"></i><a href="tel:{{ tel_link(setting('telefon')) }}">{{ setting('telefon') }}</a></div>
                <div class="contact-li"><i class="bi bi-envelope"></i><a href="mailto:{{ setting('eposta') }}">{{ setting('eposta') }}</a></div>
            </div>
        </div>
        <div class="footer-legal" style="border-top:1px solid rgba(255,255,255,.12);padding-top:16px;margin-top:8px;display:flex;flex-wrap:wrap;gap:8px 18px;font-size:.82rem">
            <a href="{{ route('legal', 'mesafeli-satis-sozlesmesi') }}">Mesafeli Satış Sözleşmesi</a>
            <a href="{{ route('legal', 'on-bilgilendirme') }}">Ön Bilgilendirme</a>
            <a href="{{ route('legal', 'iade-ve-teslimat') }}">İade & Teslimat</a>
            <a href="{{ route('legal', 'kvkk') }}">KVKK</a>
            <a href="{{ route('legal', 'gizlilik-politikasi') }}">Gizlilik</a>
            <a href="{{ route('legal', 'cerez-politikasi') }}">Çerez Politikası</a>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} {{ setting('site_adi') }}. Tüm hakları saklıdır.
        </div>
    </div>
</footer>

# Optik Magazasi E-Ticaret

Optik perakendecisi icin sepet ve odeme akisli e-ticaret sitesi.

## Ozellikler

- Kategori/urun katalogu, varyant ve indirimli fiyat destegi
- Oturum tabanli sepet, kargo ucreti ve ucretsiz kargo esigi
- Havale/EFT ve kapida odeme; iyzico 3D Secure surucusu (eklenebilir yapida)
- Stok kilidi (lockForUpdate) ile ayni anda satista asim onlemi
- Uyelik, sifre sifirlama, siparis onay ve yonetici bildirim e-postalari
- Ozel yonetim paneli, 6 yasal sayfa, sitemap ve SEO meta etiketleri

## Kullanilan teknolojiler

Laravel 13 - PHP 8.3 - MySQL - Blade - Bootstrap 5

## Bu depo hakkinda

Gercek bir musteri projesinin **portfolyo icin yayinlanmis** surumudur.
Yayina hazirlanirken canli alan adlari, gercek iletisim bilgileri, musteri
kayitlari ve uygulama anahtarlari ornek degerlerle degistirilmistir.
Kod ve mimari oldugu gibidir; veri gercek degildir.

## Kurulum

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

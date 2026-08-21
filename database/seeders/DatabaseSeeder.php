<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $img = fn ($id) => "https://images.unsplash.com/photo-{$id}?w=800&q=80";

        /* ---------------- Admin + demo müşteri ---------------- */
        $admin = User::updateOrCreate(['email' => 'admin@ornek-optik.com'], [
            'name' => 'Limon Optik Yönetici',
            'password' => Hash::make('admin123'),
            'phone' => '0252 000 00 00',
        ]);
        // role mass-assign edilemez (yetki yükseltme önlemi); sunucu tarafında forceFill ile.
        $admin->forceFill(['role' => 'admin'])->save();

        /* ---------------- Ayarlar ---------------- */
        $ayarlar = [
            'site_adi' => 'Limon Optik',
            'site_aciklama' => 'Net görüş, şık tasarım. Numaralı gözlük, güneş gözlüğü ve kontakt lenste uzman optisyen kadromuzla yanınızdayız.',
            'telefon' => '0252 412 00 00',
            'whatsapp' => '905320000000',
            'eposta' => 'info@ornek-optik.com',
            'adres' => 'Tepe Mah. Atatürk Cad. No:42, Marmaris / Muğla',
            'instagram' => 'https://instagram.com',
            'facebook' => 'https://facebook.com',
            'kargo_ucreti' => '49.90',
            'kargo_bedava_limit' => '750',
            'havale_iban' => 'TR00 0000 0000 0000 0000 0000 00',
            'havale_hesap_adi' => 'Limon Optik Ltd. Şti.',
            'havale_banka' => 'Örnek Bankası',
            'iyzico_aktif' => '0',
            'kapida_aktif' => '1',
            'yil' => '15',
        ];
        foreach ($ayarlar as $k => $v) {
            Setting::updateOrCreate(['anahtar' => $k], ['deger' => $v]);
        }
        Setting::flush();

        /* ---------------- Kategoriler ---------------- */
        $cats = [
            'numarali-gozluk' => ['Numaralı Gözlük', 'bi-eyeglasses'],
            'gunes-gozlugu'   => ['Güneş Gözlüğü', 'bi-sun'],
            'kontakt-lens'    => ['Kontakt Lens', 'bi-circle'],
            'cocuk-gozlugu'   => ['Çocuk Gözlüğü', 'bi-emoji-smile'],
            'aksesuar'        => ['Aksesuar & Bakım', 'bi-droplet'],
        ];
        $catModels = [];
        $i = 1;
        foreach ($cats as $slug => [$name, $icon]) {
            $catModels[$slug] = Category::updateOrCreate(['slug' => $slug], [
                'name' => $name, 'icon' => $icon, 'sira' => $i++, 'durum' => true,
            ]);
        }

        /* ---------------- Ürünler ---------------- */
        $products = [
            ['Klasik Asetat Optik Çerçeve', 'numarali-gozluk', 'Limon', '1574258495973-f010dfbb5371', 2450, 1990, 24,
                'Zamansız asetat çerçeve, anti-reflektif cam uyumlu.',
                ['cerceve_tipi' => 'Asetat', 'renk' => 'Kahve Desenli', 'cinsiyet' => 'Unisex'], true],
            ['Mavi Işık Filtreli Ekran Gözlüğü', 'numarali-gozluk', 'Limon', '1574258495973-f010dfbb5371', 1290, null, 40,
                'Bilgisayar ve telefon kullananlar için mavi ışık filtreli cam.',
                ['cerceve_tipi' => 'Hafif Polimer', 'renk' => 'Şeffaf', 'cinsiyet' => 'Unisex'], true],
            ['İnce Metal Numaralı Çerçeve', 'numarali-gozluk', 'Optix', '1511499767150-a48a237f0083', 1850, null, 18,
                'Ultra hafif metal çerçeve, günlük konforlu kullanım.',
                ['cerceve_tipi' => 'Metal', 'renk' => 'Altın', 'cinsiyet' => 'Kadın'], false],

            ['Aviator Güneş Gözlüğü', 'gunes-gozlugu', 'SunPro', '1511499767150-a48a237f0083', 2890, 2390, 15,
                'Polarize cam, UV400 koruma, klasik aviator tasarım.',
                ['cerceve_tipi' => 'Metal', 'renk' => 'Altın', 'cinsiyet' => 'Unisex', 'uv' => 'UV400'], true],
            ['Wayfarer Güneş Gözlüğü', 'gunes-gozlugu', 'SunPro', '1572635196237-14b3f281503f', 2190, null, 30,
                'İkonik wayfarer formu, mat siyah asetat çerçeve.',
                ['cerceve_tipi' => 'Asetat', 'renk' => 'Siyah', 'cinsiyet' => 'Unisex', 'uv' => 'UV400'], true],
            ['Cat-Eye Kadın Güneş Gözlüğü', 'gunes-gozlugu', 'Bella', '1508296695146-257a814070b4', 2650, 2190, 12,
                'Zarif cat-eye tasarım, degrade cam.',
                ['cerceve_tipi' => 'Asetat', 'renk' => 'Pudra', 'cinsiyet' => 'Kadın', 'uv' => 'UV400'], false],
            ['Şeffaf Çerçeve Güneş Gözlüğü', 'gunes-gozlugu', 'Bella', '1577803645773-f96470509666', 1990, null, 22,
                'Trend şeffaf çerçeve, kahverengi polarize cam.',
                ['cerceve_tipi' => 'Asetat', 'renk' => 'Şeffaf', 'cinsiyet' => 'Unisex', 'uv' => 'UV400'], false],

            ['Günlük Kontakt Lens (30 Adet)', 'kontakt-lens', 'ClearVue', '1606122017369-d782bbb78f32', 690, 590, 60,
                'Tek kullanımlık günlük şeffaf lens, yüksek nem oranı.',
                ['tip' => 'Günlük', 'adet' => '30', 'numara' => 'Reçeteye göre'], true],
            ['Aylık Kontakt Lens (3 Adet)', 'kontakt-lens', 'ClearVue', '1606122017369-d782bbb78f32', 850, null, 45,
                'Silikon hidrojel aylık lens, gün boyu konfor.',
                ['tip' => 'Aylık', 'adet' => '3', 'numara' => 'Reçeteye göre'], false],
            ['Renkli Kontakt Lens', 'kontakt-lens', 'Iris', '1606122017369-d782bbb78f32', 990, 790, 25,
                'Doğal görünümlü renkli lens, numaralı/numarasız seçenek.',
                ['tip' => 'Renkli', 'adet' => '2', 'renk' => 'Bal / Yeşil / Gri'], false],

            ['Çocuk Optik Gözlük', 'cocuk-gozlugu', 'KidVue', '1574258495973-f010dfbb5371', 1490, 1190, 20,
                'Esnek ve dayanıklı çocuk çerçevesi, darbeye dayanıklı cam.',
                ['cerceve_tipi' => 'Esnek TR90', 'renk' => 'Mavi', 'cinsiyet' => 'Çocuk', 'yas' => '4-10'], true],

            ['Lens Bakım Solüsyonu 360ml', 'aksesuar', 'ClearVue', '1606122017369-d782bbb78f32', 240, null, 80,
                'Çok amaçlı lens temizleme ve saklama solüsyonu.',
                ['hacim' => '360 ml', 'tip' => 'Çok amaçlı'], false],
        ];

        $s = 1;
        foreach ($products as [$name, $catSlug, $brand, $imgId, $price, $sale, $stock, $desc, $attrs, $featured]) {
            $slug = Str::slug($name);
            Product::updateOrCreate(['slug' => $slug], [
                'category_id' => $catModels[$catSlug]->id,
                'name' => $name,
                'brand' => $brand,
                'sku' => 'VO-' . str_pad((string) $s, 4, '0', STR_PAD_LEFT),
                'cover' => $img($imgId),
                'images' => [$img($imgId)],
                'short_desc' => $desc,
                'description' => $desc . "\n\nUzman optisyenlerimiz tarafından ücretsiz numara ölçümü ve montaj desteği sunulur. Tüm ürünlerimiz orijinal ve garantilidir.",
                'price' => $price,
                'sale_price' => $sale,
                'stock' => $stock,
                'attributes' => $attrs,
                'featured' => $featured,
                'sira' => $s++,
                'durum' => true,
            ]);
        }

        /* ---------------- Hizmetler ---------------- */
        // NOT: Müşteri isteğiyle hizmet listesi 4 maddeye indirildi.
        // "Güneş Gözlüğü" ve "Çocuk Gözlükleri" hizmet KARTI olarak kaldırıldı;
        // ikisi de mağazada KATEGORİ olarak duruyor (yukarıdaki $cats'e bak).
        $services = [
            ['Ücretsiz Göz Tahlili', 'ucretsiz-goz-tahlili', 'bi-eye', 'Bilgisayarlı cihazlarla hassas numara ölçümü.'],
            ['Numaralı Gözlük', 'numarali-gozluk-hizmet', 'bi-eyeglasses', 'Reçetenize uygun cam ve çerçeve seçimi.'],
            ['Kontakt Lens', 'kontakt-lens-hizmet', 'bi-circle', 'Günlük, aylık ve renkli lens uygulaması.'],
            ['Cam Değişimi & Tamir', 'cam-degisimi-tamir', 'bi-tools', 'Hızlı cam değişimi ve çerçeve onarımı.'],
        ];
        $n = 1;
        foreach ($services as [$t, $sl, $ic, $sum]) {
            Service::updateOrCreate(['slug' => $sl], [
                'title' => $t, 'icon' => $ic, 'summary' => $sum,
                'content' => $sum . ' Uzman optisyen kadromuzla en doğru çözümü birlikte belirliyoruz.',
                'sira' => $n++, 'durum' => true,
            ]);
        }

        /* ---------------- Blog ---------------- */
        $posts = [
            ['Mavi Işık Filtreli Cam Gerçekten Gerekli mi?', 'mavi-isik-filtreli-cam', 'Göz Sağlığı', '1574258495973-f010dfbb5371',
                'Ekran başında uzun süre geçirenler için mavi ışık filtreli camların faydalarını inceledik.'],
            ['Yüz Şeklinize Uygun Gözlük Çerçevesi Nasıl Seçilir?', 'yuz-sekline-gore-cerceve', 'Stil Rehberi', '1577803645773-f96470509666',
                'Yuvarlak, oval, kare ve kalp yüz tiplerine en yakışan çerçeve formlarını derledik.'],
            ['Kontakt Lens Kullanımında Hijyen Kuralları', 'kontakt-lens-hijyen', 'Bilgi', '1606122017369-d782bbb78f32',
                'Sağlıklı lens kullanımı için dikkat etmeniz gereken temel hijyen kuralları.'],
        ];
        foreach ($posts as $idx => [$t, $sl, $cat, $imgId, $sum]) {
            Post::updateOrCreate(['slug' => $sl], [
                'title' => $t, 'category' => $cat, 'image' => $img($imgId), 'summary' => $sum,
                'content' => $sum . "\n\nDetaylı bilgi ve kişisel öneri için mağazamıza bekleriz.",
                'tarih' => now()->subDays($idx * 6)->toDateString(), 'durum' => true,
            ]);
        }

        /* ---------------- Yorumlar ---------------- */
        $testi = [
            ['Ayşe K.', 'Müşteri', 'Göz tahlilim ücretsiz yapıldı, çerçeve seçiminde çok yardımcı oldular. Aynı gün teslim aldım.', 5],
            ['Mehmet T.', 'Müşteri', 'Güneş gözlüğümü buradan aldım, fiyat ve kalite gayet iyi. Tavsiye ederim.', 5],
            ['Zeynep A.', 'Müşteri', 'Çocuğum için aldığımız gözlük çok sağlam çıktı, ilgi için teşekkürler.', 4],
        ];
        foreach ($testi as [$ad, $unvan, $yorum, $yildiz]) {
            Testimonial::updateOrCreate(['name' => $ad], [
                'title' => $unvan, 'comment' => $yorum, 'stars' => $yildiz, 'durum' => true,
            ]);
        }
    }
}

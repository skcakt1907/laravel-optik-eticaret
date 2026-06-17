<h4>1. Satıcı Bilgileri</h4>
<ul>
    <li><strong>Unvan:</strong> {{ setting('havale_hesap_adi', setting('site_adi')) }}</li>
    <li><strong>Adres:</strong> {{ setting('adres') }}</li>
    <li><strong>Telefon:</strong> {{ setting('telefon') }}</li>
    <li><strong>E-Posta:</strong> {{ setting('eposta') }}</li>
</ul>

<h4>2. Sözleşme Konusu</h4>
<p>İşbu Ön Bilgilendirme Formu'nun konusu, ALICI'nın {{ setting('site_adi') }} ({{ request()->getHost() }}) internet sitesinden elektronik ortamda sipariş verdiği ürünlerin satışı ve teslimi ile ilgili olarak 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği hükümleri gereğince tarafların hak ve yükümlülüklerinin belirlenmesidir.</p>

<h4>3. Ürün ve Ödeme Bilgileri</h4>
<p>Sipariş edilen ürünlerin temel nitelikleri, satış fiyatı (KDV dahil), ödeme şekli ve teslimat bilgileri, sipariş onay sayfasında ve sipariş onay e-postasında ALICI'ya bildirilir. Listelenen fiyatlar güncel satış fiyatlarıdır.</p>

<h4>4. Cayma Hakkı</h4>
<p>ALICI, ürünü teslim aldığı tarihten itibaren <strong>14 (on dört) gün</strong> içinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin sözleşmeden cayma hakkına sahiptir. Cayma hakkının kullanılması için bu süre içinde {{ setting('eposta') }} adresine bildirimde bulunulması yeterlidir.</p>
<p>Niteliği itibarıyla iade edilemeyecek ürünler (kişiye özel üretilen numaralı/dereceli gözlük camları, hijyenik nedenlerle açılmış kontakt lensler vb.) cayma hakkı kapsamı dışındadır.</p>

<h4>5. Teslimat</h4>
<p>Ürünler, ödemenin onaylanmasını takiben en geç 30 gün içinde ALICI'nın belirttiği adrese kargo ile teslim edilir. Kargo ücreti ve ücretsiz kargo limiti sepet ve ödeme sayfasında belirtilir.</p>

<h4>6. Uyuşmazlık Çözümü</h4>
<p>İşbu sözleşmeden doğabilecek uyuşmazlıklarda, Ticaret Bakanlığı'nca ilan edilen değer sınırlarına göre Tüketici Hakem Heyetleri ve Tüketici Mahkemeleri yetkilidir.</p>

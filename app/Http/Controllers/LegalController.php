<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public const PAGES = [
        'mesafeli-satis-sozlesmesi' => ['Mesafeli Satış Sözleşmesi', 'legal.mesafeli-satis'],
        'on-bilgilendirme'          => ['Ön Bilgilendirme Formu', 'legal.on-bilgilendirme'],
        'iade-ve-teslimat'          => ['İade ve Teslimat Koşulları', 'legal.iade-teslimat'],
        'kvkk'                      => ['KVKK Aydınlatma Metni', 'legal.kvkk'],
        'gizlilik-politikasi'       => ['Gizlilik Politikası', 'legal.gizlilik'],
        'cerez-politikasi'          => ['Çerez Politikası', 'legal.cerez'],
    ];

    public function show(string $slug)
    {
        abort_unless(isset(self::PAGES[$slug]), 404);

        [$title, $view] = self::PAGES[$slug];

        return view('pages.legal.wrapper', [
            'pageTitle' => $title,
            'bodyView'  => $view,
        ]);
    }
}

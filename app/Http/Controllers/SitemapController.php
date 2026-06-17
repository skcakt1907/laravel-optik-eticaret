<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        // NOT: arrow fn (fn()) dış değişkeni değerle yakalar; bu yüzden $urls'e
        // doğrudan ekleme yapıyoruz (referans sorununu önlemek için).
        $urls = [];

        foreach ([route('home'), route('shop'), route('services'), route('blog'), route('about'), route('contact')] as $loc) {
            $urls[] = ['loc' => $loc, 'lastmod' => null];
        }

        foreach (LegalController::PAGES as $slug => $_) {
            $urls[] = ['loc' => route('legal', $slug), 'lastmod' => null];
        }

        foreach (Category::where('durum', true)->get() as $c) {
            $urls[] = ['loc' => route('shop', ['kategori' => $c->slug]), 'lastmod' => null];
        }
        foreach (Product::where('durum', true)->get() as $p) {
            $urls[] = ['loc' => route('product', $p), 'lastmod' => optional($p->updated_at)->toAtomString()];
        }
        foreach (Service::where('durum', true)->get() as $s) {
            $urls[] = ['loc' => route('service.show', $s), 'lastmod' => null];
        }
        foreach (Post::where('durum', true)->get() as $p) {
            $urls[] = ['loc' => route('blog.show', $p), 'lastmod' => optional($p->updated_at)->toAtomString()];
        }

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}

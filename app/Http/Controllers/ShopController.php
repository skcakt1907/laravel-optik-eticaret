<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->whereNull('parent_id')
            ->withCount(['products' => fn ($q) => $q->where('durum', true)])
            ->orderBy('sira')->get();

        $query = Product::active()->with('category');

        $activeCat = null;
        if ($request->filled('kategori')) {
            $activeCat = Category::where('slug', $request->kategori)->first();
            if ($activeCat) {
                $query->where('category_id', $activeCat->id);
            }
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        match ($request->get('sirala')) {
            'ucuz'   => $query->orderByRaw('COALESCE(sale_price, price) asc'),
            'pahali' => $query->orderByRaw('COALESCE(sale_price, price) desc'),
            'yeni'   => $query->latest(),
            default  => $query->orderBy('sira'),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories', 'activeCat'));
    }

    public function show(Product $product)
    {
        abort_unless($product->durum, 404);

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}

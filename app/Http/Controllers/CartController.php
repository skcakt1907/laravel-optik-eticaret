<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index', [
            'items'    => Cart::items(),
            'subtotal' => Cart::subtotal(),
            'shipping' => Cart::shipping(),
            'total'    => Cart::total(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        abort_unless($product->durum, 404);

        if ($product->stock <= 0) {
            return back()->with('error', 'Bu ürün stokta yok.');
        }

        $qty = max(1, (int) $request->input('qty', 1));
        Cart::add($product, $qty);

        return back()->with('success', $product->name . ' sepete eklendi.');
    }

    public function update(Request $request)
    {
        $qtys = $request->input('qty', []);
        foreach ($qtys as $id => $qty) {
            Cart::update((int) $id, (int) $qty);
        }
        return back()->with('success', 'Sepet güncellendi.');
    }

    public function remove(int $id)
    {
        Cart::remove($id);
        return back()->with('success', 'Ürün sepetten çıkarıldı.');
    }
}

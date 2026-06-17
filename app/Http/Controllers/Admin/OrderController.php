<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::latest();
        if ($request->filled('durum')) {
            $query->where('status', $request->durum);
        }
        if ($request->filled('q')) {
            $query->where(fn ($w) => $w->where('order_no', 'like', '%'.$request->q.'%')->orWhere('name', 'like', '%'.$request->q.'%'));
        }

        return view('admin.orders.index', [
            'orders' => $query->paginate(20)->withQueryString(),
            'labels' => Order::statusLabels(),
        ]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order'  => $order->load('items'),
            'labels' => Order::statusLabels(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'         => 'required|in:'.implode(',', array_keys(Order::statusLabels())),
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        // status/payment_status korumalı alanlar; admin enum-doğrulamalı olarak forceFill ile yazar.
        $order->forceFill($data)->save();

        return back()->with('success', 'Sipariş güncellendi.');
    }
}

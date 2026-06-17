<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index', [
            'user'        => auth()->user(),
            'orderCount'  => auth()->user()->orders()->count(),
            'lastOrders'  => auth()->user()->orders()->latest()->take(3)->get(),
        ]);
    }

    public function orders()
    {
        return view('account.orders', [
            'orders' => auth()->user()->orders()->latest()->paginate(10),
        ]);
    }

    public function orderShow(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('account.order', ['order' => $order->load('items')]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'     => 'required|string|max:120',
            'phone'    => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? null;
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('success', 'Bilgileriniz güncellendi.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'orderCount'    => Order::count(),
            'pendingCount'  => Order::where('status', 'yeni')->count(),
            'productCount'  => Product::count(),
            'lowStock'      => Product::where('stock', '<', 5)->count(),
            'revenue'       => Order::where('payment_status', 'paid')->sum('total'),
            'apptCount'     => Appointment::where('status', 'yeni')->count(),
            'recentOrders'  => Order::latest()->take(8)->get(),
        ]);
    }
}

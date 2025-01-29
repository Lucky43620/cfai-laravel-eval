<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total_amount'),
            'total_products' => Product::count(),
            'total_customers' => User::count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $low_stock_products = Product::where('stock', '<', 10)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }
} 
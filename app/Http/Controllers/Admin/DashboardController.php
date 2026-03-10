<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->where('stock_quantity', '>', 0)->count();

        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();


        $pendingOrders = Order::where('status', 'Pending')->count();

        $totalRevenue = Order::where('status', '!=', 'Cancelled')->sum('total_amount');

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'lowStockCount',
            'outOfStockCount',
            'pendingOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }
}

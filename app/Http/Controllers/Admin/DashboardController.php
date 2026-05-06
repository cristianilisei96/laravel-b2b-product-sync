<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ImportLog;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'orders_count' => Order::count(),
            'pending_orders_count' => Order::where('status', 'pending')->count(),
            'low_stock_products_count' => Product::where('stock', '<=', 5)->count(),
        ];

        $latestImport = ImportLog::query()
            ->latest()
            ->first();

        $latestOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::query()
            ->with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'latestImport' => $latestImport,
            'latestOrders' => $latestOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}

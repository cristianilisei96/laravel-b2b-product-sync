<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('shop.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items');

        return view('shop.orders.show', [
            'order' => $order,
        ]);
    }
}

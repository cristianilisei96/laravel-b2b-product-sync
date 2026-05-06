<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $cartItems = CartItem::query()
            ->with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('shop.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function (CartItem $cartItem) {
            return (float) $cartItem->product->price * $cartItem->quantity;
        });

        return view('shop.checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cartItems = CartItem::query()
            ->with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('shop.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        try {
            $order = DB::transaction(function () use ($request, $validated, $cartItems): Order {
                $subtotal = 0;

                foreach ($cartItems as $cartItem) {
                    $product = Product::query()
                        ->lockForUpdate()
                        ->findOrFail($cartItem->product_id);

                    if (!$product->is_active || $product->stock < $cartItem->quantity) {
                        throw new \RuntimeException('Product "' . $product->name . '" does not have enough stock.');
                    }

                    $subtotal += (float) $product->price * $cartItem->quantity;
                }

                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'order_number' => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'notes' => $validated['notes'] ?? null,
                ]);

                foreach ($cartItems as $cartItem) {
                    $product = Product::query()
                        ->lockForUpdate()
                        ->findOrFail($cartItem->product_id);

                    $lineTotal = (float) $product->price * $cartItem->quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'unit_price' => $product->price,
                        'quantity' => $cartItem->quantity,
                        'line_total' => $lineTotal,
                    ]);

                    $product->decrement('stock', $cartItem->quantity);

                    if ($product->fresh()->stock <= 0) {
                        $product->update([
                            'stock_status' => 'out_of_stock',
                        ]);
                    }
                }

                CartItem::query()
                    ->where('user_id', $request->user()->id)
                    ->delete();

                return $order;
            });
        } catch (\Throwable $exception) {
            return redirect()
                ->route('shop.cart.index')
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('shop.orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }
}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Shopping Cart
            </h2>

            <a href="{{ route('shop.products.index') }}" class="text-sm text-blue-600 hover:underline">
                Continue shopping
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($cartItems->isEmpty())
                    <div class="text-center py-10">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Your cart is empty
                        </h3>

                        <p class="text-gray-600 mb-6">
                            Browse the catalog and add some products to your cart.
                        </p>

                        <a href="{{ route('shop.products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Browse products
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Product</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Price</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Quantity</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($cartItems as $cartItem)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                @if ($cartItem->product->thumbnail)
                                                    <img src="{{ $cartItem->product->thumbnail }}"
                                                        alt="{{ $cartItem->product->name }}"
                                                        class="h-14 w-14 object-cover rounded">
                                                @else
                                                    <div
                                                        class="h-14 w-14 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400">
                                                        No image
                                                    </div>
                                                @endif

                                                <div>
                                                    <a href="{{ route('shop.products.show', $cartItem->product) }}"
                                                        class="font-medium text-gray-900 hover:underline">
                                                        {{ $cartItem->product->name }}
                                                    </a>

                                                    <div class="text-xs text-gray-500">
                                                        SKU: {{ $cartItem->product->sku }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3">
                                            ${{ number_format((float) $cartItem->product->price, 2) }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <form method="POST" action="{{ route('shop.cart.update', $cartItem) }}"
                                                class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}"
                                                    min="1" max="{{ $cartItem->product->stock }}"
                                                    class="w-20 rounded-md border-gray-300 shadow-sm">

                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                                                    Update
                                                </button>
                                            </form>
                                        </td>

                                        <td class="px-4 py-3 font-semibold">
                                            ${{ number_format((float) $cartItem->product->price * $cartItem->quantity, 2) }}
                                        </td>

                                        <td class="px-4 py-3 text-right">
                                            <form method="POST" action="{{ route('shop.cart.destroy', $cartItem) }}"
                                                onsubmit="return confirm('Remove this product from cart?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-sm text-red-600 hover:underline">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t pt-6">
                        <div>
                            <div class="text-sm text-gray-500">
                                Cart subtotal
                            </div>

                            <div class="text-2xl font-bold text-gray-900">
                                ${{ number_format($subtotal, 2) }}
                            </div>
                        </div>

                        <button type="button"
                            class="inline-flex justify-center items-center px-5 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Checkout demo coming next
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

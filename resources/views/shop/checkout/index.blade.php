<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Checkout
            </h2>

            <a href="{{ route('shop.cart.index') }}" class="text-sm text-blue-600 hover:underline">
                Back to cart
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Order notes</h3>

                    <form method="POST" action="{{ route('shop.checkout.store') }}" id="checkout-form">
                        @csrf

                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            Notes
                        </label>

                        <textarea id="notes" name="notes" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Optional notes for this demo order...">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Order summary</h3>

                    <div class="space-y-4">
                        @foreach ($cartItems as $cartItem)
                            <div class="flex justify-between gap-4 text-sm">
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ $cartItem->product->name }}
                                    </div>

                                    <div class="text-gray-500">
                                        Qty: {{ $cartItem->quantity }}
                                    </div>
                                </div>

                                <div class="font-medium">
                                    ${{ number_format((float) $cartItem->product->price * $cartItem->quantity, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t mt-6 pt-6 flex justify-between">
                        <span class="font-semibold text-gray-900">Total</span>
                        <span class="font-bold text-gray-900">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>

                    <button type="submit" form="checkout-form"
                        class="mt-6 inline-flex w-full justify-center items-center px-5 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Place demo order
                    </button>

                    <p class="text-xs text-gray-500 mt-3">
                        This is a demo checkout. No real payment is processed.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

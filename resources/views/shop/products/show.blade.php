<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product Details
            </h2>

            <a href="{{ route('shop.products.index') }}" class="text-sm text-blue-600 hover:underline">
                Back to products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <div>
                        @if ($product->thumbnail)
                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                class="w-full rounded-lg object-cover">
                        @else
                            <div
                                class="h-96 w-full bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                No image
                            </div>
                        @endif

                        @if ($product->images->isNotEmpty())
                            <div class="grid grid-cols-4 gap-3 mt-4">
                                @foreach ($product->images as $image)
                                    <img src="{{ $image->url }}" alt="{{ $product->name }}"
                                        class="h-24 w-full object-cover rounded border">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-2">
                            {{ $product->category?->name ?? 'Uncategorized' }}
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $product->name }}
                        </h1>

                        <div class="mt-2 text-gray-500">
                            Brand: {{ $product->brand ?? '-' }}
                        </div>

                        <div class="mt-2 text-gray-500">
                            SKU: {{ $product->sku }}
                        </div>

                        <div class="mt-6 text-3xl font-bold text-gray-900">
                            ${{ number_format((float) $product->price, 2) }}
                        </div>

                        <div class="mt-4">
                            <span
                                class="inline-flex items-center rounded px-3 py-1 text-sm font-medium
                                @if ($product->stock_status === 'in_stock') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ $product->stock }} available / {{ str_replace('_', ' ', $product->stock_status) }}
                            </span>
                        </div>

                        <div class="mt-8">
                            <h2 class="font-semibold text-gray-900 mb-2">Description</h2>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div class="mt-8">
                            @auth
                                <form method="POST" action="{{ route('shop.cart.store', $product) }}" class="space-y-4">
                                    @csrf

                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700">
                                            Quantity
                                        </label>

                                        <input type="number" id="quantity" name="quantity"
                                            value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock }}"
                                            class="mt-1 block w-28 rounded-md border-gray-300 shadow-sm">

                                        @error('quantity')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="inline-flex w-full justify-center items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @disabled($product->stock <= 0)>
                                        Add to cart
                                    </button>

                                    @if ($product->stock <= 0)
                                        <p class="text-xs text-red-600">
                                            This product is currently out of stock.
                                        </p>
                                    @endif
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex w-full justify-center items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Login to add to cart
                                </a>

                                <p class="text-xs text-gray-500 mt-2">
                                    You need an account to add products to your cart.
                                </p>
                            @endauth
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

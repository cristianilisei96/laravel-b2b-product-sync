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
                                @else bg-red-100 text-red-700 @endif
                            ">
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
                            <button type="button"
                                class="inline-flex w-full justify-center items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Add to cart demo
                            </button>

                            <p class="text-xs text-gray-500 mt-2">
                                Cart and checkout flow will be implemented in the next phase.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

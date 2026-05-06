<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product Catalog
            </h2>

            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">
                Back to dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('shop.products.index') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" id="search" name="search" value="{{ $search }}"
                            placeholder="Search products..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="category_id" name="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">All categories</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((int) $categoryId === $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Filter
                        </button>

                        <a href="{{ route('shop.products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <a href="{{ route('shop.products.show', $product) }}">
                            @if ($product->thumbnail)
                                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                    class="h-48 w-full object-cover">
                            @else
                                <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    No image
                                </div>
                            @endif
                        </a>

                        <div class="p-5">
                            <div class="text-xs text-gray-500 mb-1">
                                {{ $product->category?->name ?? 'Uncategorized' }}
                            </div>

                            <a href="{{ route('shop.products.show', $product) }}">
                                <h3 class="font-semibold text-gray-900 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ $product->brand ?? 'No brand' }}
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-lg font-bold text-gray-900">
                                    ${{ number_format((float) $product->price, 2) }}
                                </div>

                                <span
                                    class="inline-flex items-center rounded px-2 py-1 text-xs font-medium
                                    @if ($product->stock_status === 'in_stock') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700 @endif
                                ">
                                    {{ $product->stock_status === 'in_stock' ? 'In stock' : 'Out of stock' }}
                                </span>
                            </div>

                            <a href="{{ route('shop.products.show', $product) }}"
                                class="mt-4 inline-flex w-full justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                View product
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded shadow-sm text-center text-gray-500">
                        No products found.
                    </div>
                @endforelse
            </div>

            <div>
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

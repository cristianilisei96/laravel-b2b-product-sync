<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>

            <div class="flex gap-4">
                <a href="{{ route('admin.supplier-imports.index') }}" class="text-sm text-blue-600 hover:underline">
                    Supplier imports
                </a>

                <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                    Back to dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Product catalog</h3>

                <form method="GET" action="{{ route('admin.products.index') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" id="search" name="search" value="{{ $search }}"
                            placeholder="Name, SKU or brand"
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

                        <a href="{{ route('admin.products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Image</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Product</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">SKU</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Category</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Brand</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Supplier Price</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Selling Price</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Stock</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Synced</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-4 py-2">
                                        @if ($product->thumbnail)
                                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                                                class="h-14 w-14 object-cover rounded">
                                        @else
                                            <div
                                                class="h-14 w-14 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400">
                                                No image
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-2 font-medium text-gray-900 max-w-xs">
                                        {{ $product->name }}
                                    </td>

                                    <td class="px-4 py-2 text-gray-600">
                                        {{ $product->sku }}
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $product->category?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $product->brand ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2">
                                        ${{ number_format((float) $product->supplier_price, 2) }}
                                    </td>

                                    <td class="px-4 py-2 font-semibold">
                                        ${{ number_format((float) $product->price, 2) }}
                                    </td>

                                    <td class="px-4 py-2">
                                        <span
                                            class="inline-flex items-center rounded px-2 py-1 text-xs font-medium
                                            @if ($product->stock_status === 'in_stock') bg-green-100 text-green-700
                                            @else bg-red-100 text-red-700 @endif
                                        ">
                                            {{ $product->stock }} /
                                            {{ str_replace('_', ' ', $product->stock_status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2 text-gray-600">
                                        {{ $product->last_synced_at ? \Illuminate\Support\Carbon::parse($product->last_synced_at)->format('Y-m-d H:i') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

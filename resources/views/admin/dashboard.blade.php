<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>

            <a href="{{ route('shop.products.index') }}" class="text-sm text-blue-600 hover:underline">
                View shop
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Products</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $stats['products_count'] }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Categories</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $stats['categories_count'] }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Orders</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $stats['orders_count'] }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Pending Orders</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $stats['pending_orders_count'] }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Low Stock</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $stats['low_stock_products_count'] }}
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    SupplierHub Admin
                </h3>

                <p class="text-gray-600 mb-6">
                    Manage supplier imports, imported products, customer orders and product stock from one place.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.supplier-imports.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Manage supplier imports
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                        View products
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                        View orders
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Latest supplier import
                    </h3>

                    @if ($latestImport)
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500">Status</div>
                                <div class="font-semibold">
                                    {{ ucfirst($latestImport->status) }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Date</div>
                                <div class="font-semibold">
                                    {{ $latestImport->created_at?->format('Y-m-d H:i') }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Created</div>
                                <div class="font-semibold">
                                    {{ $latestImport->products_created }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Updated</div>
                                <div class="font-semibold">
                                    {{ $latestImport->products_updated }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Skipped</div>
                                <div class="font-semibold">
                                    {{ $latestImport->products_skipped }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">API Offset</div>
                                <div class="font-semibold">
                                    {{ $latestImport->context['skip'] ?? '-' }}
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-600">
                            No supplier imports yet.
                        </p>
                    @endif
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Latest orders
                    </h3>

                    @if ($latestOrders->isEmpty())
                        <p class="text-gray-600">
                            No orders yet.
                        </p>
                    @else
                        <div class="space-y-3">
                            @foreach ($latestOrders as $order)
                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div>
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="font-medium text-gray-900 hover:underline">
                                            {{ $order->order_number }}
                                        </a>

                                        <div class="text-xs text-gray-500">
                                            {{ $order->user?->name ?? '-' }} ·
                                            {{ $order->created_at?->format('Y-m-d H:i') }}
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <div class="font-semibold">
                                            ${{ number_format((float) $order->total, 2) }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Low stock products
                </h3>

                @if ($lowStockProducts->isEmpty())
                    <p class="text-gray-600">
                        No low stock products.
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Product</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">SKU</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Category</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Stock</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-500">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($lowStockProducts as $product)
                                    <tr>
                                        <td class="px-4 py-2 font-medium text-gray-900">
                                            {{ $product->name }}
                                        </td>

                                        <td class="px-4 py-2 text-gray-600">
                                            {{ $product->sku }}
                                        </td>

                                        <td class="px-4 py-2 text-gray-600">
                                            {{ $product->category?->name ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $product->stock }}
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('admin.products.index', ['search' => $product->sku]) }}"
                                                class="text-blue-600 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

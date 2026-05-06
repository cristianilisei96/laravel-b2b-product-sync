<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order {{ $order->order_number }}
            </h2>

            <a href="{{ route('shop.orders.index') }}" class="text-sm text-blue-600 hover:underline">
                Back to orders
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="font-semibold">{{ ucfirst($order->status) }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Total</div>
                        <div class="font-semibold">${{ number_format((float) $order->total, 2) }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Date</div>
                        <div class="font-semibold">{{ $order->created_at?->format('Y-m-d H:i') }}</div>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="mb-6">
                        <div class="text-sm text-gray-500">Notes</div>
                        <div class="text-gray-700">{{ $order->notes }}</div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Product</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">SKU</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Unit Price</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Qty</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500">Total</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item->product_name }}</td>
                                    <td class="px-4 py-2">{{ $item->product_sku }}</td>
                                    <td class="px-4 py-2">${{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 font-semibold">
                                        ${{ number_format((float) $item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

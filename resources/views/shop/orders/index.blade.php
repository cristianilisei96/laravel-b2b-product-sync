<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Orders
            </h2>

            <a href="{{ route('shop.products.index') }}" class="text-sm text-blue-600 hover:underline">
                Continue shopping
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($orders->isEmpty())
                    <p class="text-gray-600">No orders yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Order</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-4 py-2 font-medium">
                                            {{ $order->order_number }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ ucfirst($order->status) }}
                                        </td>

                                        <td class="px-4 py-2">
                                            ${{ number_format((float) $order->total, 2) }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $order->created_at?->format('Y-m-d H:i') }}
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('shop.orders.show', $order) }}"
                                                class="text-blue-600 hover:underline">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

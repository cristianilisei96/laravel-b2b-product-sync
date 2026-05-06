<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>

            <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                Back to dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('admin.orders.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" id="search" name="search" value="{{ $search }}"
                            placeholder="Order number, customer name or email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">All statuses</option>

                            @foreach ($statuses as $statusKey => $statusLabel)
                                <option value="{{ $statusKey }}" @selected($status === $statusKey)>
                                    {{ $statusLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Filter
                        </button>

                        <a href="{{ route('admin.orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                            Reset
                        </a>
                    </div>
                </form>

                @if ($orders->isEmpty())
                    <p class="text-gray-600">No orders found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Order</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Customer</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-4 py-2 font-medium text-gray-900">
                                            {{ $order->order_number }}
                                        </td>

                                        <td class="px-4 py-2">
                                            <div class="font-medium text-gray-900">
                                                {{ $order->user?->name ?? '-' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $order->user?->email ?? '-' }}
                                            </div>
                                        </td>

                                        <td class="px-4 py-2">
                                            <span
                                                class="inline-flex items-center rounded px-2 py-1 text-xs font-medium
                                                @if ($order->status === 'completed') bg-green-100 text-green-700
                                                @elseif ($order->status === 'cancelled') bg-red-100 text-red-700
                                                @elseif ($order->status === 'processing') bg-blue-100 text-blue-700
                                                @else bg-yellow-100 text-yellow-700 @endif
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-2 font-semibold">
                                            ${{ number_format((float) $order->total, 2) }}
                                        </td>

                                        <td class="px-4 py-2 text-gray-600">
                                            {{ $order->created_at?->format('Y-m-d H:i') }}
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}"
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

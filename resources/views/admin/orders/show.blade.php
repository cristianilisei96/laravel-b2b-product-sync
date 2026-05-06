<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order {{ $order->order_number }}
            </h2>

            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Order items</h3>

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

                    @if ($order->notes)
                        <div class="mt-6 border-t pt-6">
                            <div class="text-sm text-gray-500">Customer notes</div>
                            <div class="text-gray-700 mt-1">{{ $order->notes }}</div>
                        </div>
                    @endif
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Order summary</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Customer</span>
                                <span class="font-medium text-right">{{ $order->user?->name ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Email</span>
                                <span class="font-medium text-right">{{ $order->user?->email ?? '-' }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium">${{ number_format((float) $order->subtotal, 2) }}</span>
                            </div>

                            <div class="flex justify-between border-t pt-3">
                                <span class="font-semibold">Total</span>
                                <span class="font-bold">${{ number_format((float) $order->total, 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Created</span>
                                <span class="font-medium">{{ $order->created_at?->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Update status</h3>

                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}"
                            class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>

                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach ($statuses as $statusKey => $statusLabel)
                                        <option value="{{ $statusKey }}" @selected($order->status === $statusKey)>
                                            {{ $statusLabel }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="inline-flex w-full justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Save status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

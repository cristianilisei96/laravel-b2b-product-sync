<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Supplier Product Import
            </h2>

            <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                Back to dashboard
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

            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Import products from supplier API</h3>

                <p class="text-gray-600 mb-6">
                    This tool imports products from the external supplier API, creates or updates categories,
                    products, stock, prices and product images.
                </p>

                <form method="POST" action="{{ route('admin.supplier-imports.store') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="limit" class="block text-sm font-medium text-gray-700">Limit</label>

                            <input type="number" id="limit" name="limit" value="{{ old('limit', 10) }}"
                                min="1" max="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                            @error('limit')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="skip" class="block text-sm font-medium text-gray-700">API Skip /
                                Offset</label>

                            <input type="number" id="skip" name="skip" value="{{ old('skip', 0) }}"
                                min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                            @error('skip')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="text-sm text-gray-500">
                        Example: <code>limit = 10</code> and <code>skip = 20</code> imports products 21-30 from the
                        supplier API.
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Import products
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Latest import logs</h3>

                @if ($importLogs->isEmpty())
                    <p class="text-gray-600">No imports yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Date</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Limit</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">API Skip</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Status</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Created</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Updated</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Skipped</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500">Message</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach ($importLogs as $log)
                                    <tr>
                                        <td class="px-4 py-2">
                                            {{ $log->created_at?->format('Y-m-d H:i') }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $log->context['limit'] ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $log->context['skip'] ?? '-' }}
                                        </td>

                                        <td class="px-4 py-2">
                                            <span
                                                class="inline-flex items-center rounded px-2 py-1 text-xs font-medium
                                                @if ($log->status === 'success') bg-green-100 text-green-700
                                                @elseif ($log->status === 'partial') bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif
                                            ">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $log->products_created }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $log->products_updated }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $log->products_skipped }}
                                        </td>

                                        <td class="px-4 py-2">
                                            {{ $log->message }}
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

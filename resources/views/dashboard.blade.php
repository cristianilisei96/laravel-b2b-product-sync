<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customer Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">
                        Welcome to your customer dashboard
                    </h3>

                    <p class="text-gray-600 mb-6">
                        Browse the product catalog, view product details and later place demo orders.
                    </p>

                    <a href="{{ route('shop.products.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Browse products
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

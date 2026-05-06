<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Welcome, Admin</h3>

                <p class="text-gray-600">
                    This area will be used to manage products, categories, supplier imports, stock synchronization and
                    orders.
                </p>
            </div>
            <div class="mt-6">
                <a href="{{ route('admin.supplier-imports.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Manage supplier imports
                </a>
            </div>
        </div>

    </div>


</x-app-layout>

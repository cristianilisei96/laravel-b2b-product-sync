<x-app-layout>
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center rounded-full bg-gray-200 px-3 py-1 text-sm text-gray-700 mb-6">
                    Laravel Portfolio Project
                </div>

                <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900 leading-tight">
                    B2B product sync platform for supplier-based e-commerce
                </h1>

                <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                    A Laravel application that imports products from an external supplier API,
                    synchronizes categories, prices, stock and images, and provides admin tools
                    for product management and import logs.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('shop.products.index') }}"
                        class="inline-flex justify-center items-center px-5 py-3 bg-gray-900 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700">
                        Browse catalog
                    </a>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex justify-center items-center px-5 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-100">
                                Admin dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex justify-center items-center px-5 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-100">
                                Customer dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex justify-center items-center px-5 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-100">
                            Login demo
                        </a>
                    @endauth
                </div>

                <div class="mt-6 text-sm text-gray-500">
                    Demo accounts:
                    <span class="font-medium">admin@gmail.com</span> /
                    <span class="font-medium">customer@gmail.com</span>,
                    password:
                    <span class="font-medium">12345678</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                        <div class="text-3xl font-bold text-gray-900">
                            API
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            External supplier integration using DummyJSON.
                        </p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                        <div class="text-3xl font-bold text-gray-900">
                            Sync
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Products are updated by external ID to avoid duplicates.
                        </p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                        <div class="text-3xl font-bold text-gray-900">
                            Admin
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Import tools, logs and product management.
                        </p>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-5 border border-gray-100">
                        <div class="text-3xl font-bold text-gray-900">
                            Shop
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            Customer catalog with product details and filtering.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">
                Main features
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-xl border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">
                        Role-based access
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Separate Admin and Customer roles with protected admin routes and role-based redirects.
                    </p>
                </div>

                <div class="p-6 rounded-xl border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">
                        Supplier product import
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Products, categories, prices, stock and images are imported from an external API.
                    </p>
                </div>

                <div class="p-6 rounded-xl border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">
                        Import logs
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Each import stores created, updated and skipped products, including limit and offset parameters.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">
                Tech stack
            </h2>

            <div class="flex flex-wrap gap-3">
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">Laravel</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">PHP</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">MySQL</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">Blade</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">Tailwind CSS</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">External API</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">Artisan Commands</span>
                <span class="px-4 py-2 rounded-full bg-white border border-gray-200 text-sm">Role Middleware</span>
            </div>
        </div>
    </section>

    <footer class="border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-gray-500 flex flex-col sm:flex-row justify-between gap-2">
            <span>
                Laravel B2B Product Sync
            </span>

            <span>
                Portfolio project by Cristian Ilisei
            </span>
        </div>
    </footer>
</x-app-layout>

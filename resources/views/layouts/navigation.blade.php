<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">
                SupplierHub
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden sm:flex items-center gap-4">
                <a href="{{ route('shop.products.index') }}"
                    class="text-sm {{ request()->routeIs('shop.products.*') ? 'text-gray-900 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                    Shop
                </a>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm {{ request()->routeIs('admin.*') ? 'text-gray-900 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="text-sm {{ request()->routeIs('dashboard') ? 'text-gray-900 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                            Dashboard
                        </a>
                    @endif

                    <a href="{{ route('shop.cart.index') }}"
                        class="text-sm {{ request()->routeIs('shop.cart.*') ? 'text-gray-900 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                        Cart
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                                <span>{{ Auth::user()->name }}</span>

                                <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Register
                    </a>
                @endauth
            </div>

            {{-- Mobile button --}}
            <div class="sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-gray-200">
        <div class="px-6 py-4 space-y-3">
            <a href="{{ route('shop.products.index') }}"
                class="block text-sm {{ request()->routeIs('shop.products.*') ? 'text-gray-900 font-medium' : 'text-gray-600' }}">
                Shop
            </a>

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="block text-sm {{ request()->routeIs('admin.*') ? 'text-gray-900 font-medium' : 'text-gray-600' }}">
                        Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="block text-sm {{ request()->routeIs('dashboard') ? 'text-gray-900 font-medium' : 'text-gray-600' }}">
                        Dashboard
                    </a>
                @endif

                <a href="{{ route('shop.cart.index') }}"
                    class="block text-sm {{ request()->routeIs('shop.cart.*') ? 'text-gray-900 font-medium' : 'text-gray-600' }}">
                    Cart
                </a>

                <a href="{{ route('profile.edit') }}" class="block text-sm text-gray-600">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="block text-sm text-gray-600">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm text-gray-600">
                    Login
                </a>

                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>

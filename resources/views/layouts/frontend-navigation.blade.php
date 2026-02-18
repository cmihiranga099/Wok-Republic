@php
    $cartCount = collect(session('cart', []))->sum('quantity');
@endphp

<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
     :class="scrolled ? 'bg-gray-900/95 backdrop-blur-md shadow-lg' : 'bg-gray-800'"
     class="fixed top-0 left-0 right-0 z-40 border-b border-gray-700 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <h1 class="text-2xl font-bold text-secondary font-serif">Wok Republic</h1>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                    <x-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.*')">Menu</x-nav-link>
                    <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">Reservations</x-nav-link>
                    <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.*')">Contact</x-nav-link>
                    <x-nav-link :href="route('about.index')" :active="request()->routeIs('about.*')">About</x-nav-link>
                    <x-nav-link :href="route('track.order.index')" :active="request()->routeIs('track.*')">Track Order</x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('customer.profile.edit')">Profile</x-dropdown-link>
                            <x-dropdown-link :href="route('customer.orders.index')">My Orders</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')">Login</x-nav-link>
                    <x-nav-link :href="route('register')" class="ml-2">Register</x-nav-link>
                @endauth

                <a href="{{ route('cart.index') }}" class="relative ml-4 inline-flex items-center px-1 pt-1 text-gray-300 hover:text-secondary transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-2 bg-primary text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <a href="{{ route('cart.index') }}" class="relative mr-3 text-gray-300 hover:text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-2 bg-primary text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-900">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.*')">Menu</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">Reservations</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.*')">Contact</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about.index')" :active="request()->routeIs('about.*')">About</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('track.order.index')" :active="request()->routeIs('track.*')">Track Order</x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-700">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('customer.profile.edit')">Profile</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('customer.orders.index')">My Orders</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <x-responsive-nav-link :href="route('login')">Login</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">Register</x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
<div class="h-16"></div>

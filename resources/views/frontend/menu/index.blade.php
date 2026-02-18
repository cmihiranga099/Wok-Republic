<x-frontend-layout>
    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white font-serif">Our Menu</h1>
                <p class="mt-4 text-lg text-gray-400">Discover our collection of authentic Asian dishes</p>
            </div>

            <div class="lg:flex lg:gap-8">
                <!-- Filters Sidebar -->
                <aside x-data="{ filtersOpen: false }" class="lg:w-1/4 mb-8 lg:mb-0">
                    <!-- Mobile Toggle -->
                    <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full bg-gray-800 text-white py-3 px-4 rounded-lg flex items-center justify-between mb-4">
                        <span class="font-semibold">Filters</span>
                        <svg :class="{ 'rotate-180': filtersOpen }" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div :class="{ 'hidden lg:block': !filtersOpen }" class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white mb-6 font-serif">Filters</h3>

                        <!-- Search -->
                        <div class="mb-6">
                            <form action="{{ route('menu.index') }}" method="GET">
                                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                                @if(request('dietary'))<input type="hidden" name="dietary" value="{{ request('dietary') }}">@endif
                                @if(request('spicy_level'))<input type="hidden" name="spicy_level" value="{{ request('spicy_level') }}">@endif
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search dishes..." class="form-input-dark w-full text-sm">
                            </form>
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-secondary mb-3 uppercase tracking-wider">Categories</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('menu.index', request()->except('category')) }}" class="text-sm transition {{ !request('category') ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">
                                        All Categories
                                    </a>
                                </li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('menu.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}" class="text-sm transition {{ request('category') == $category->slug ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Dietary -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-secondary mb-3 uppercase tracking-wider">Dietary</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('menu.index', request()->except('dietary')) }}" class="text-sm transition {{ !request('dietary') ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">All</a>
                                </li>
                                <li>
                                    <a href="{{ route('menu.index', array_merge(request()->except('dietary'), ['dietary' => 'veg'])) }}" class="text-sm transition {{ request('dietary') == 'veg' ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">Vegetarian</a>
                                </li>
                                <li>
                                    <a href="{{ route('menu.index', array_merge(request()->except('dietary'), ['dietary' => 'non-veg'])) }}" class="text-sm transition {{ request('dietary') == 'non-veg' ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">Non-Vegetarian</a>
                                </li>
                                <li>
                                    <a href="{{ route('menu.index', array_merge(request()->except('dietary'), ['dietary' => 'egg'])) }}" class="text-sm transition {{ request('dietary') == 'egg' ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">Egg</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Spicy Level -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-secondary mb-3 uppercase tracking-wider">Spicy Level</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('menu.index', request()->except('spicy_level')) }}" class="text-sm transition {{ !request('spicy_level') && request('spicy_level') !== '0' ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">All</a>
                                </li>
                                @for($i = 0; $i <= 3; $i++)
                                    <li>
                                        <a href="{{ route('menu.index', array_merge(request()->except('spicy_level'), ['spicy_level' => $i])) }}" class="text-sm transition {{ request('spicy_level') == (string)$i && request()->has('spicy_level') ? 'text-secondary font-bold' : 'text-gray-300 hover:text-secondary' }}">
                                            @if($i == 0) Not Spicy @elseif($i == 1) Mild @elseif($i == 2) Medium @else Hot @endif
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>

                        @if(request()->hasAny(['category', 'dietary', 'spicy_level', 'search']))
                            <a href="{{ route('menu.index') }}" class="block text-center text-sm text-red-400 hover:text-red-300 transition">Clear All Filters</a>
                        @endif
                    </div>
                </aside>

                <!-- Dishes Grid -->
                <main class="lg:w-3/4">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        @forelse($dishes as $dish)
                            <x-dish-card :dish="$dish" />
                        @empty
                            <div class="col-span-full text-center py-16">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <p class="text-xl text-gray-400">No dishes found matching your criteria.</p>
                                <a href="{{ route('menu.index') }}" class="mt-4 inline-block text-secondary hover:underline">View all dishes</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12">
                        {{ $dishes->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-frontend-layout>

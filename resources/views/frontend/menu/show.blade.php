<x-frontend-layout>
    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8 text-sm">
                <ol class="flex items-center space-x-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-secondary transition">Home</a></li>
                    <li><span>/</span></li>
                    <li><a href="{{ route('menu.index') }}" class="hover:text-secondary transition">Menu</a></li>
                    @if($dish->category)
                        <li><span>/</span></li>
                        <li><a href="{{ route('menu.index', ['category' => $dish->category->slug]) }}" class="hover:text-secondary transition">{{ $dish->category->name }}</a></li>
                    @endif
                    <li><span>/</span></li>
                    <li class="text-secondary">{{ $dish->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Image Gallery -->
                <div>
                    <img src="{{ $dish->image ?? 'https://via.placeholder.com/600x400/1f2937/6b7280?text=' . urlencode($dish->name) }}" alt="{{ $dish->name }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
                    @if($dish->images->isNotEmpty())
                        <div class="grid grid-cols-4 gap-2 mt-4">
                            @foreach($dish->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $dish->name }}" class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 transition">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Dish Information -->
                <div class="text-white">
                    <h1 class="text-4xl font-bold font-serif text-secondary">{{ $dish->name }}</h1>

                    <div class="mt-4 flex items-center space-x-4">
                        @if($dish->discount_price)
                            <span class="text-3xl font-bold text-secondary">${{ number_format($dish->discount_price, 2) }}</span>
                            <span class="text-lg text-gray-500 line-through">${{ number_format($dish->price, 2) }}</span>
                        @else
                            <span class="text-3xl font-bold text-secondary">${{ number_format($dish->price, 2) }}</span>
                        @endif

                        <div class="flex space-x-2">
                            @if($dish->spicy_level > 0)
                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Spicy {{ $dish->spicy_level }}/3</span>
                            @endif
                            @if($dish->veg_non_veg === 'veg')
                                <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Veg</span>
                            @else
                                <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">Non-Veg</span>
                            @endif
                        </div>
                    </div>

                    <p class="mt-6 text-gray-300 leading-relaxed">{{ $dish->description }}</p>

                    @if($dish->ingredients)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-secondary mb-2">Ingredients</h3>
                            <p class="text-gray-400">{{ $dish->ingredients }}</p>
                        </div>
                    @endif

                    @if($dish->allergens)
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-secondary mb-2">Allergens</h3>
                            <p class="text-gray-400">{{ $dish->allergens }}</p>
                        </div>
                    @endif

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-8">
                        @csrf
                        <input type="hidden" name="dish_id" value="{{ $dish->id }}">

                        @if($dish->addons->isNotEmpty())
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-secondary mb-3">Add-ons</h3>
                                <div class="space-y-3">
                                    @foreach($dish->addons as $addon)
                                        <label class="flex items-center text-gray-300 cursor-pointer hover:text-white transition">
                                            <input type="checkbox" name="addons[]" value="{{ $addon->id }}" class="form-checkbox bg-gray-700 border-gray-600 text-primary rounded">
                                            <span class="ml-3">{{ $addon->name }} (+${{ number_format($addon->price, 2) }})</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <label for="quantity" class="mr-3 font-semibold">Qty:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-input w-20 bg-gray-800 border-gray-700 rounded-md text-center text-white">
                            </div>
                            <button type="submit" class="btn-primary">Add to Cart</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Customer Reviews Section -->
            <div class="mt-16 pt-12 border-t border-gray-700">
                <h2 class="text-3xl font-bold text-white font-serif mb-8">Customer Reviews</h2>
                <div class="space-y-6">
                    @forelse($dish->reviews->where('status', true) as $review)
                        <div class="bg-gray-800 p-6 rounded-lg">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-white font-medium">{{ $review->user->name ?? 'Anonymous' }}</div>
                                    <div class="text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="ml-auto flex">
                                    @for($j = 1; $j <= 5; $j++)
                                        <svg class="h-5 w-5 {{ $j <= $review->rating ? 'text-secondary' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.959a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.959c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.176 0l-3.368 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.959a1 1 0 00-.364-1.118L2.06 9.386c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-300">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400">No reviews yet. Be the first to review this dish!</p>
                        </div>
                    @endforelse

                    @auth
                        <div class="text-center mt-6">
                            <a href="{{ route('customer.reviews.create', $dish->slug) }}" class="text-secondary hover:underline font-semibold">Write a Review</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Related Dishes -->
            @if($relatedDishes->isNotEmpty())
                <div class="mt-16 pt-12 border-t border-gray-700">
                    <h2 class="text-3xl font-bold text-white font-serif mb-8">You Might Also Like</h2>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($relatedDishes as $related)
                            <x-dish-card :dish="$related" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>

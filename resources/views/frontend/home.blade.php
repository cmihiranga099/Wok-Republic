<x-frontend-layout>
    {{-- Hero Section --}}
    <div class="relative bg-gray-900 overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://via.placeholder.com/1920x1080/000000/000000?text=+" alt="Wok Republic Restaurant">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/80 to-gray-900/40"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-32 px-4 sm:py-40 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-6xl lg:text-7xl font-serif animate-fade-in-up">
                <span class="text-secondary">Authentic Flavors</span> of Asia
            </h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s">
                Experience the taste of tradition. Every dish tells a story, every bite a journey through the heart of Asian cuisine.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.4s">
                <a href="{{ route('menu.index') }}" class="btn-primary text-base">View Our Menu</a>
                <a href="{{ route('reservations.index') }}" class="btn-secondary text-base">Book a Table</a>
            </div>
        </div>
    </div>

    {{-- Popular Dishes Section --}}
    <div class="bg-gray-900 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-serif">Our Popular Dishes</h2>
                <p class="mt-4 text-lg text-gray-400">Loved by our customers, crafted by our chefs.</p>
            </div>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($popularDishes as $dish)
                    <x-dish-card :dish="$dish" />
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('menu.index') }}" class="text-secondary hover:text-yellow-400 font-semibold text-lg transition">
                    View All Dishes &rarr;
                </a>
            </div>
        </div>
    </div>

    {{-- Categories Section --}}
    <div class="bg-gray-800 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-serif">Explore Our Menu</h2>
                <p class="mt-4 text-lg text-gray-400">From appetizers to desserts, we have it all.</p>
            </div>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($categories as $category)
                    <x-category-card :category="$category" />
                @endforeach
            </div>
        </div>
    </div>

    {{-- Why Choose Us Section --}}
    <div class="bg-gray-900 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-serif">Why Choose Us</h2>
                <p class="mt-4 text-lg text-gray-400">What makes Wok Republic special.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="bg-gray-800 rounded-lg p-8 text-center hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Fresh Ingredients</h3>
                    <p class="text-gray-400">We source only the freshest ingredients daily from local farms and trusted suppliers.</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-8 text-center hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Fast Delivery</h3>
                    <p class="text-gray-400">Hot and fresh at your doorstep. We ensure your food arrives quickly and in perfect condition.</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-8 text-center hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Authentic Recipes</h3>
                    <p class="text-gray-400">Traditional recipes passed down through generations, prepared by our expert chefs.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Testimonials Section --}}
    @if($testimonials->isNotEmpty())
    <div class="bg-gray-800 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-serif">What Our Customers Say</h2>
                <p class="mt-4 text-lg text-gray-400">Real reviews from real food lovers.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($testimonials as $testimonial)
                    <div class="bg-gray-900 rounded-lg p-6 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            @if($testimonial->rating)
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-5 w-5 {{ $i <= $testimonial->rating ? 'text-secondary' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.959a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.959c.3.921-.755 1.688-1.54 1.118l-3.368-2.448a1 1 0 00-1.176 0l-3.368 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.959a1 1 0 00-.364-1.118L2.06 9.386c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                        </svg>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-300 italic mb-4">"{{ $testimonial->testimonial_text }}"</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                            </div>
                            <span class="ml-3 text-white font-medium">{{ $testimonial->customer_name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- CTA Section --}}
    <div class="bg-primary">
        <div class="max-w-4xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl font-serif">
                <span class="block">Ready to dive in?</span>
                <span class="block text-secondary mt-2">Book a table or order online today.</span>
            </h2>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('reservations.index') }}" class="btn-secondary">Make a Reservation</a>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-gray-700 hover:bg-gray-600 transition-all duration-300">View Menu</a>
            </div>
        </div>
    </div>
</x-frontend-layout>

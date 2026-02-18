@props(['dish'])

<div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden group hover:shadow-2xl hover:shadow-primary/10 transition-all duration-300 hover:-translate-y-1">
    <a href="{{ route('menu.show', $dish->slug) }}" class="block">
        <div class="relative overflow-hidden">
            <img class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $dish->image ?? 'https://via.placeholder.com/400x300/1f2937/6b7280?text=' . urlencode($dish->name) }}" alt="{{ $dish->name }}">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute top-2 left-2 flex space-x-2">
                @if($dish->spicy_level > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">Spicy {{ $dish->spicy_level }}/3</span>
                @endif
                @if($dish->veg_non_veg === 'veg')
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Veg</span>
                @endif
                @if($dish->discount_price)
                    <span class="bg-secondary text-gray-900 text-xs font-bold px-2 py-1 rounded-full">Sale</span>
                @endif
            </div>
        </div>
    </a>
    <div class="p-4">
        <a href="{{ route('menu.show', $dish->slug) }}">
            <h3 class="text-lg font-semibold text-white hover:text-secondary transition">{{ $dish->name }}</h3>
        </a>
        <p class="text-gray-400 mt-1 text-sm h-10 overflow-hidden">{{ Str::limit($dish->description, 60) }}</p>
        <div class="mt-4 flex items-center justify-between">
            @if($dish->discount_price)
                <div>
                    <span class="text-xl font-bold text-secondary">${{ number_format($dish->discount_price, 2) }}</span>
                    <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($dish->price, 2) }}</span>
                </div>
            @else
                <span class="text-xl font-bold text-secondary">${{ number_format($dish->price, 2) }}</span>
            @endif
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="bg-primary hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded-full transition-all duration-300 hover:scale-110">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>

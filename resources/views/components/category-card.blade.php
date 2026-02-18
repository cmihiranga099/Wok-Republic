@props(['category'])

<a href="{{ route('menu.index', ['category' => $category->slug]) }}" class="block relative rounded-lg shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300">
    <div class="overflow-hidden">
        <img class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $category->image ?? 'https://via.placeholder.com/400x300/1f2937/6b7280?text=' . urlencode($category->name) }}" alt="{{ $category->name }}">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end p-6">
        <div>
            <h3 class="text-2xl font-bold text-white font-serif tracking-wider group-hover:text-secondary transition-colors duration-300">{{ $category->name }}</h3>
            @if($category->description)
                <p class="text-gray-300 text-sm mt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ Str::limit($category->description, 50) }}</p>
            @endif
        </div>
    </div>
</a>

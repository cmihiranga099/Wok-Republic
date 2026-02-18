<x-frontend-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-white font-serif mb-8">Your Cart</h1>

            @if(count($cart) > 0)
                <div class="lg:flex lg:gap-8">
                    <!-- Cart Items -->
                    <div class="lg:w-2/3 space-y-4">
                        @foreach($cart as $index => $item)
                            <div class="bg-gray-800 rounded-lg p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <img src="{{ $item['image'] ?? 'https://via.placeholder.com/100x100/1f2937/6b7280?text=' . urlencode($item['name']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg shrink-0">

                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('menu.show', $item['slug']) }}" class="text-lg font-semibold text-white hover:text-secondary transition">{{ $item['name'] }}</a>
                                    @if(!empty($item['addons']))
                                        <p class="text-sm text-gray-400 mt-1">
                                            Add-ons: {{ collect($item['addons'])->pluck('name')->implode(', ') }}
                                        </p>
                                    @endif
                                    <p class="text-secondary font-bold mt-1">${{ number_format($item['unit_price'] + $item['addons_total'], 2) }} each</p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-2">
                                    @if($item['quantity'] > 1)
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="index" value="{{ $index }}">
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                            <button type="submit" class="w-8 h-8 bg-gray-700 hover:bg-gray-600 text-white rounded flex items-center justify-center transition">-</button>
                                        </form>
                                    @else
                                        <span class="w-8 h-8 bg-gray-700 text-gray-500 rounded flex items-center justify-center">-</span>
                                    @endif

                                    <span class="w-10 text-center text-white font-semibold">{{ $item['quantity'] }}</span>

                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="index" value="{{ $index }}">
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="w-8 h-8 bg-gray-700 hover:bg-gray-600 text-white rounded flex items-center justify-center transition">+</button>
                                    </form>
                                </div>

                                <!-- Line Total -->
                                <div class="text-right shrink-0">
                                    <p class="text-lg font-bold text-secondary">${{ number_format($item['line_total'], 2) }}</p>
                                    <form action="{{ route('cart.remove') }}" method="POST" class="mt-1">
                                        @csrf
                                        <input type="hidden" name="index" value="{{ $index }}">
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3 mt-8 lg:mt-0">
                        <div class="bg-gray-800 rounded-lg p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-white font-serif mb-6">Order Summary</h2>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between text-gray-300">
                                    <span>Subtotal</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Delivery Fee</span>
                                    <span>${{ number_format($deliveryFee, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-700 pt-3 flex justify-between text-white font-bold text-lg">
                                    <span>Total</span>
                                    <span class="text-secondary">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block mt-6">Proceed to Checkout</a>
                            <a href="{{ route('menu.index') }}" class="block text-center text-gray-400 hover:text-secondary mt-3 text-sm transition">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <svg class="w-24 h-24 text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-white mb-4">Your cart is empty</h2>
                    <p class="text-gray-400 mb-8">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('menu.index') }}" class="btn-primary">Browse Menu</a>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>

<x-frontend-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-white font-serif mb-8">Checkout</h1>

            <form action="{{ route('checkout.placeOrder') }}" method="POST">
                @csrf
                <div class="lg:flex lg:gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:w-2/3">
                        <div class="bg-gray-800 rounded-lg p-6 mb-6">
                            <h2 class="text-xl font-bold text-white font-serif mb-6">Your Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label-dark">Full Name *</label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" required class="form-input-dark">
                                </div>
                                <div>
                                    <label class="form-label-dark">Email *</label>
                                    <input type="email" name="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" required class="form-input-dark">
                                </div>
                                <div>
                                    <label class="form-label-dark">Phone *</label>
                                    <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone ?? '') }}" required class="form-input-dark">
                                </div>
                                <div>
                                    <label class="form-label-dark">Payment Method *</label>
                                    <select name="payment_method" class="form-input-dark">
                                        <option value="cod">Cash on Delivery</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800 rounded-lg p-6 mb-6" x-data="{ deliveryType: '{{ old('delivery_pickup', 'delivery') }}' }">
                            <h2 class="text-xl font-bold text-white font-serif mb-6">Delivery Options</h2>
                            <div class="flex gap-4 mb-6">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="delivery_pickup" value="delivery" x-model="deliveryType" class="sr-only peer">
                                    <div class="border-2 border-gray-600 peer-checked:border-secondary rounded-lg p-4 text-center transition">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400 peer-checked:text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                        <span class="text-white font-semibold">Delivery</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="delivery_pickup" value="pickup" x-model="deliveryType" class="sr-only peer">
                                    <div class="border-2 border-gray-600 peer-checked:border-secondary rounded-lg p-4 text-center transition">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400 peer-checked:text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <span class="text-white font-semibold">Pickup</span>
                                    </div>
                                </label>
                            </div>

                            <div x-show="deliveryType === 'delivery'" x-transition>
                                <label class="form-label-dark">Delivery Address *</label>
                                <textarea name="delivery_address" rows="3" class="form-input-dark" placeholder="Enter your full delivery address">{{ old('delivery_address') }}</textarea>
                            </div>
                        </div>

                        <div class="bg-gray-800 rounded-lg p-6">
                            <h2 class="text-xl font-bold text-white font-serif mb-4">Notes</h2>
                            <textarea name="notes" rows="3" class="form-input-dark" placeholder="Any special instructions for your order?">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3 mt-8 lg:mt-0">
                        <div class="bg-gray-800 rounded-lg p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-white font-serif mb-6">Order Summary</h2>
                            <div class="space-y-4 mb-6">
                                @foreach($cart as $item)
                                    <div class="flex justify-between text-sm">
                                        <div class="text-gray-300">
                                            <span>{{ $item['name'] }}</span>
                                            <span class="text-gray-500"> x{{ $item['quantity'] }}</span>
                                        </div>
                                        <span class="text-gray-300">${{ number_format($item['line_total'], 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t border-gray-700 pt-4 space-y-3 text-sm">
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
                            <button type="submit" class="btn-primary w-full text-center block mt-6">Place Order</button>
                            <a href="{{ route('cart.index') }}" class="block text-center text-gray-400 hover:text-secondary mt-3 text-sm transition">Back to Cart</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-frontend-layout>

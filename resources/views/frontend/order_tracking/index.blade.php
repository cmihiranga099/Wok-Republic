<x-frontend-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white font-serif">Track Your Order</h1>
                <p class="mt-4 text-lg text-gray-400">Enter your order code to see the current status of your order.</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-8">
                <form action="{{ route('track.order') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="order_code" class="form-label-dark">Order Code</label>
                        <input type="text" name="order_code" id="order_code" value="{{ old('order_code') }}" placeholder="e.g. WR-ABCD1234" required class="form-input-dark text-center text-lg tracking-widest uppercase">
                    </div>
                    <button type="submit" class="btn-primary w-full text-center">Track Order</button>
                </form>
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-400 text-sm">Your order code was provided when you placed your order. Check your email or order confirmation.</p>
            </div>
        </div>
    </div>
</x-frontend-layout>

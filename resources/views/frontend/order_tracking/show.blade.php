@php
    $statuses = ['pending', 'preparing', 'ready', 'out_for_delivery', 'delivered'];
    $statusLabels = [
        'pending' => 'Order Placed',
        'preparing' => 'Preparing',
        'ready' => 'Ready',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
    ];
    $currentIndex = array_search($order->order_status, $statuses);
    if ($order->order_status === 'cancelled') {
        $currentIndex = -1;
    }
@endphp

<x-frontend-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-white font-serif">Order Status</h1>
                <p class="mt-2 text-secondary text-lg font-mono">{{ $order->order_code }}</p>
            </div>

            @if($order->order_status === 'cancelled')
                <div class="bg-red-900/50 border border-red-700 rounded-lg p-6 text-center mb-8">
                    <p class="text-red-300 text-lg font-semibold">This order has been cancelled.</p>
                </div>
            @else
                <!-- Status Timeline -->
                <div class="bg-gray-800 rounded-lg p-6 sm:p-8 mb-8">
                    <div class="flex items-center justify-between relative">
                        <!-- Progress Line -->
                        <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-600">
                            <div class="h-full bg-secondary transition-all duration-500" style="width: {{ $currentIndex >= 0 ? ($currentIndex / (count($statuses) - 1)) * 100 : 0 }}%"></div>
                        </div>

                        @foreach($statuses as $i => $status)
                            <div class="relative flex flex-col items-center z-10">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $i <= $currentIndex ? 'bg-secondary text-gray-900' : 'bg-gray-600 text-gray-400' }} transition-all duration-300">
                                    @if($i < $currentIndex)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @elseif($i == $currentIndex)
                                        <div class="w-3 h-3 bg-gray-900 rounded-full animate-pulse"></div>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </div>
                                <span class="mt-2 text-xs text-center {{ $i <= $currentIndex ? 'text-secondary font-semibold' : 'text-gray-500' }} hidden sm:block">
                                    {{ $statusLabels[$status] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-center text-white font-semibold mt-6 sm:hidden">
                        Current: {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                    </p>
                </div>
            @endif

            <!-- Order Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-white font-serif mb-4">Order Details</h2>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Customer</dt>
                            <dd class="text-white">{{ $order->customer_name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Email</dt>
                            <dd class="text-white">{{ $order->customer_email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Phone</dt>
                            <dd class="text-white">{{ $order->customer_phone }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Type</dt>
                            <dd class="text-white capitalize">{{ $order->delivery_pickup }}</dd>
                        </div>
                        @if($order->delivery_address)
                            <div class="flex justify-between">
                                <dt class="text-gray-400">Address</dt>
                                <dd class="text-white text-right max-w-48">{{ $order->delivery_address }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Placed</dt>
                            <dd class="text-white">{{ $order->created_at->format('M d, Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-white font-serif mb-4">Items Ordered</h2>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-300">{{ $item->dish_name }} <span class="text-gray-500">x{{ $item->quantity }}</span></span>
                                <span class="text-gray-300">${{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-700 mt-4 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-300">
                            <span>Subtotal</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-300">
                            <span>Delivery Fee</span>
                            <span>${{ number_format($order->delivery_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-white font-bold text-lg border-t border-gray-700 pt-2">
                            <span>Total</span>
                            <span class="text-secondary">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('track.order.index') }}" class="text-secondary hover:underline">Track another order</a>
            </div>
        </div>
    </div>
</x-frontend-layout>

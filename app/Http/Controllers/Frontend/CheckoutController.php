<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddon;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum('line_total');
        $deliveryFee = 5.00;
        $total = $subtotal + $deliveryFee;
        $user = auth()->user();

        return view('frontend.checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_pickup' => 'required|in:delivery,pickup',
            'delivery_address' => 'required_if:delivery_pickup,delivery|nullable|string|max:500',
            'payment_method' => 'required|in:cod',
            'notes' => 'nullable|string|max:1000',
        ]);

        $subtotal = collect($cart)->sum('line_total');
        $deliveryFee = $request->delivery_pickup === 'delivery' ? 5.00 : 0;
        $total = $subtotal + $deliveryFee;

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_code' => 'WR-' . strtoupper(Str::random(8)),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'delivery_address' => $request->delivery_address,
            'delivery_fee' => $deliveryFee,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'delivery_pickup' => $request->delivery_pickup,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $item['dish_id'],
                'dish_name' => $item['name'],
                'price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'total' => $item['line_total'],
            ]);

            if (!empty($item['addons'])) {
                foreach ($item['addons'] as $addon) {
                    OrderItemAddon::create([
                        'order_item_id' => $orderItem->id,
                        'addon_name' => $addon['name'],
                        'addon_price' => $addon['price'],
                    ]);
                }
            }
        }

        session()->forget('cart');

        return redirect()->route('track.order.index')->with('success', 'Order placed successfully! Your order code is: ' . $order->order_code);
    }
}

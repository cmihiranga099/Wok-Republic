<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Addon;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum('line_total');
        $deliveryFee = $subtotal > 0 ? 5.00 : 0;
        $total = $subtotal + $deliveryFee;

        return view('frontend.cart.index', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'quantity' => 'required|integer|min:1',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
        ]);

        $dish = Dish::findOrFail($request->dish_id);
        $quantity = $request->quantity;
        $selectedAddons = [];
        $addonsTotal = 0;

        if ($request->has('addons')) {
            $addons = Addon::whereIn('id', $request->addons)->get();
            foreach ($addons as $addon) {
                $selectedAddons[] = [
                    'id' => $addon->id,
                    'name' => $addon->name,
                    'price' => $addon->price,
                ];
                $addonsTotal += $addon->price;
            }
        }

        $unitPrice = $dish->discount_price ?? $dish->price;
        $lineTotal = ($unitPrice + $addonsTotal) * $quantity;

        $cartItem = [
            'dish_id' => $dish->id,
            'name' => $dish->name,
            'slug' => $dish->slug,
            'image' => $dish->image,
            'unit_price' => $unitPrice,
            'addons' => $selectedAddons,
            'addons_total' => $addonsTotal,
            'quantity' => $quantity,
            'line_total' => $lineTotal,
        ];

        $cart = session('cart', []);
        $cart[] = $cartItem;
        session(['cart' => $cart]);

        return redirect()->back()->with('success', $dish->name . ' added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'index' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        if (isset($cart[$request->index])) {
            $item = &$cart[$request->index];
            $item['quantity'] = $request->quantity;
            $item['line_total'] = ($item['unit_price'] + $item['addons_total']) * $item['quantity'];
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'index' => 'required|integer|min:0',
        ]);

        $cart = session('cart', []);

        if (isset($cart[$request->index])) {
            array_splice($cart, $request->index, 1);
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}

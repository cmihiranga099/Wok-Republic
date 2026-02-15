<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.cart.index');
    }

    public function add(Request $request)
    {
        // Logic to add item to cart
        return redirect()->back()->with('success', 'Item added to cart.');
    }

    public function update(Request $request)
    {
        // Logic to update item in cart
        return redirect()->back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        // Logic to remove item from cart
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    public function index(): View
    {
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        // Ensure the authenticated user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('customer.orders.show', compact('order'));
    }
}

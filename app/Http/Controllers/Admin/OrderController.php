<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->search, fn($q, $s) => $q->where('order_code', 'like', "%{$s}%")->orWhere('customer_name', 'like', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('order_status', $s))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.addons', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,preparing,ready,out_for_delivery,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed',
        ]);

        $order->update($request->only('order_status', 'payment_status'));

        return redirect()->route('orders.show', $order)->with('success', 'Order status updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }

    public function create() { abort(404); }
    public function store() { abort(404); }
}

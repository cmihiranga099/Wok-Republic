<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('frontend.order_tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string',
        ]);

        $order = Order::where('order_code', $request->order_code)->with('items')->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found. Please check your order code.');
        }

        return view('frontend.order_tracking.show', compact('order'));
    }
}

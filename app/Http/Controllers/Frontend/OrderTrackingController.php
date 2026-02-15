<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('frontend.order_tracking.index');
    }

    public function track(Request $request)
    {
        // Logic to track order
        return view('frontend.order_tracking.show');
    }
}

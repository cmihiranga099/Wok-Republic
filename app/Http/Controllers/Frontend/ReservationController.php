<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('frontend.reservations.index');
    }

    public function store(Request $request)
    {
        // Logic to store reservation
        return redirect()->back()->with('success', 'Reservation placed successfully!');
    }
}

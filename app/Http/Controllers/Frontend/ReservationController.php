<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        return view('frontend.reservations.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'reservation_date' => 'required|date|after:now',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        Reservation::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'reservation_date' => $request->reservation_date,
            'number_of_guests' => $request->number_of_guests,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Reservation submitted successfully! We will confirm your booking shortly.');
    }
}

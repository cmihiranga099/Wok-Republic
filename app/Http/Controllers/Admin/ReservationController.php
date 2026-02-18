<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Reservation::when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,declined',
            'table_number' => 'nullable|string|max:20',
        ]);

        $reservation->update($request->only('status', 'table_number'));

        return redirect()->route('reservations.show', $reservation)->with('success', 'Reservation updated.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted.');
    }

    public function create() { abort(404); }
    public function store() { abort(404); }
    public function edit(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }
}

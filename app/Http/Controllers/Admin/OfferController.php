<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = Offer::when($request->search, fn($q, $s) => $q->where('code', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:offers',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'min_order' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after:now',
            'status' => 'boolean',
        ]);

        Offer::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'description' => $request->description,
            'min_order' => $request->min_order,
            'expiry_date' => $request->expiry_date,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
    }

    public function show(Offer $offer)
    {
        return view('admin.offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:offers,code,' . $offer->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'min_order' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date|after:now',
            'status' => 'boolean',
        ]);

        $offer->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'description' => $request->description,
            'min_order' => $request->min_order,
            'expiry_date' => $request->expiry_date,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully.');
    }
}

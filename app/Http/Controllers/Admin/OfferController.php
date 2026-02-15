<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.offers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Logic to store offer
        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return view('admin.offers.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('admin.offers.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Logic to update offer
        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Logic to delete offer
        return redirect()->route('admin.offers.index')->with('success', 'Offer deleted successfully.');
    }
}

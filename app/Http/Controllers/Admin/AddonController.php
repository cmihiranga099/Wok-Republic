<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.addons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.addons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Logic to store addon
        return redirect()->route('admin.addons.index')->with('success', 'Addon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return view('admin.addons.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('admin.addons.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Logic to update addon
        return redirect()->route('admin.addons.index')->with('success', 'Addon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Logic to delete addon
        return redirect()->route('admin.addons.index')->with('success', 'Addon deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        $addons = Addon::when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addons',
            'price' => 'required|numeric|min:0',
            'status' => 'boolean',
        ]);

        Addon::create([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('addons.index')->with('success', 'Addon created successfully.');
    }

    public function show(Addon $addon)
    {
        return view('admin.addons.show', compact('addon'));
    }

    public function edit(Addon $addon)
    {
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:addons,name,' . $addon->id,
            'price' => 'required|numeric|min:0',
            'status' => 'boolean',
        ]);

        $addon->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('addons.index')->with('success', 'Addon updated successfully.');
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();
        return redirect()->route('addons.index')->with('success', 'Addon deleted successfully.');
    }
}

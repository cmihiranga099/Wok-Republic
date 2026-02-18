<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Addon;
use App\Models\DishImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function index(Request $request)
    {
        $dishes = Dish::with('category')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->category, fn($q, $c) => $q->where('category_id', $c))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.dishes.index', compact('dishes', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $addons = Addon::where('status', true)->orderBy('name')->get();
        return view('admin.dishes.create', compact('categories', 'addons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'ingredients' => 'nullable|string',
            'allergens' => 'nullable|string',
            'veg_non_veg' => 'required|in:veg,non-veg,egg',
            'spicy_level' => 'required|integer|min:0|max:3',
            'status' => 'boolean',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);
        $data['status'] = $request->has('status');

        $dish = Dish::create($data);

        if ($request->has('addons')) {
            $dish->addons()->attach($request->addons);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                DishImage::create([
                    'dish_id' => $dish->id,
                    'image_path' => $image->store('dishes', 'public'),
                    'is_thumbnail' => $i === 0,
                ]);
            }
        }

        return redirect()->route('dishes.index')->with('success', 'Dish created successfully.');
    }

    public function show(Dish $dish)
    {
        $dish->load(['category', 'addons', 'images', 'reviews.user']);
        return view('admin.dishes.show', compact('dish'));
    }

    public function edit(Dish $dish)
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $addons = Addon::where('status', true)->orderBy('name')->get();
        $dish->load(['addons', 'images']);
        return view('admin.dishes.edit', compact('dish', 'categories', 'addons'));
    }

    public function update(Request $request, Dish $dish)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'ingredients' => 'nullable|string',
            'allergens' => 'nullable|string',
            'veg_non_veg' => 'required|in:veg,non-veg,egg',
            'spicy_level' => 'required|integer|min:0|max:3',
            'status' => 'boolean',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $data['status'] = $request->has('status');
        $dish->update($data);
        $dish->addons()->sync($request->addons ?? []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                DishImage::create([
                    'dish_id' => $dish->id,
                    'image_path' => $image->store('dishes', 'public'),
                    'is_thumbnail' => false,
                ]);
            }
        }

        return redirect()->route('dishes.index')->with('success', 'Dish updated successfully.');
    }

    public function destroy(Dish $dish)
    {
        foreach ($dish->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Dish deleted successfully.');
    }
}

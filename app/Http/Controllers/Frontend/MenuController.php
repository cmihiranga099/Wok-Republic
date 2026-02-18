<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Category;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', true)->orderBy('sort_order')->get();
        $dishes = Dish::where('status', true);

        if ($request->filled('category')) {
            $dishes->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        if ($request->filled('dietary')) {
            $dishes->where('veg_non_veg', $request->dietary);
        }

        if ($request->filled('spicy_level')) {
            $dishes->where('spicy_level', $request->spicy_level);
        }

        if ($request->filled('search')) {
            $dishes->where('name', 'like', '%' . $request->search . '%');
        }

        $dishes = $dishes->latest()->paginate(12)->withQueryString();

        return view('frontend.menu.index', compact('categories', 'dishes'));
    }

    public function show(string $slug)
    {
        $dish = Dish::where('slug', $slug)->with(['addons', 'images', 'reviews.user', 'category'])->firstOrFail();
        $relatedDishes = Dish::where('category_id', $dish->category_id)
            ->where('id', '!=', $dish->id)
            ->where('status', true)
            ->take(4)
            ->get();

        return view('frontend.menu.show', compact('dish', 'relatedDishes'));
    }
}
